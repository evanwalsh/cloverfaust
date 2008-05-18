<?
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
##############################################################
# Class Unzip v2.6
#
#  @package     unzip
#  @subpackage  Library
#  @category    Archief
#  @author      Jaapio (fphpcode.nl) 
#  @copyright   Copyright (c) 2007, fphpcode.nl
#  @license        http://www.gnu.org/licenses/lgpl.html
#  @version     1.0.0-alpha 
#  @inpiredFrom: Alexandre Tedeschi (d) (alexandrebr at gmail dot com)
#
#  Objective:
#    This class allows programmer to easily unzip files on the fly.
#
#  Requirements:
#    This class requires extension ZLib Enabled. It is default
#    for most site hosts around the world, and for the PHP Win32 dist.
#
#  To do:
#   * Error handling
#   * Write a PHP-Side gzinflate, to completely avoid any external extensions
#   * Write other decompress algorithms
#
#  If you modify this class, or have any ideas to improve it, please contact me!
#  You are allowed to redistribute this class, if you keep my name and contact e-mail on it.
#
#  PLEASE! IF YOU USE THIS CLASS IN ANY OF YOUR PROJECTS, PLEASE LET ME KNOW!
#  If you have problems using it, don't think twice before contacting me!
#
##############################################################

if(!function_exists('file_put_contents')){
    // If not PHP5, creates a compatible function
    Function file_put_contents($file, $data){
        if($tmp = fopen($file, "w")){
            fwrite($tmp, $data);
            fclose($tmp);
            return true;
        }
        echo "<b>file_put_contents:</b> Cannot create file $file<br>";
        return false;
    }
}

class Unzip{
    Function getVersion(){
        return "2.6";
    }
    var $fileName          = '';
    var $compressedList    = Array(); // You will problably use only this one!
    var $centralDirList    = Array(); // Central dir list... It's a kind of 'extra attributes' for a set of files
    var $endOfCentral      = Array(); // End of central dir, contains ZIP Comments
    var $info              = Array();
    var $error             = Array();
    var $targetDir         = false;
    var $baseDir           = "";
    var $maintainStructure = true;
    var $applyChmod        = 0777;
    var $fh;
    var $zipSignature = "\x50\x4b\x03\x04"; // local file header signature
    var $dirSignature = "\x50\x4b\x01\x02"; // central dir header signature
    var $dirSignatureE= "\x50\x4b\x05\x06"; // end of central dir signature
    
    // --------------------------------------------------------------------
    /**
     * Constructor
     *
     * @access    Public
     * @param     string
     * @return    none
     */
    Function Unzip($props = array())
    {
        if (count($props) > 0)
        {
            $this->initialize($props);
        }
        
        //log_message('debug', "Unzip Class Initialized");
    }
    // --------------------------------------------------------------------
    
    /**
     * initialize image preferences
     *
     * @access    public
     * @param    array
     * @return    void
     */    
    function initialize($props = array())
    {
        /*
         * Convert array elements into class variables
         */
        if (count($props) > 0)
        {
            foreach ($props as $key => $val)
            {
                $this->$key = $val;
            }
        }
    }
    // --------------------------------------------------------------------
    /**
     * List all files in archive.
     *
     * @access    Public
     * @param     boolean
     * @return    mixed
     */    
    Function getList($stopOnFile=false){
        if(sizeof($this->compressedList)){
            $this->debugMsg(1, "Returning already loaded file list.");
            return $this->compressedList;
        }
        
        // Open file, and set file handler
        $fh = fopen($this->fileName, "r");
        $this->fh = &$fh;
        if(!$fh){
            $this->debugMsg(2, "Failed to load file: ".$this->fileName);
            return false;
        }
        
        $this->debugMsg(1, "Loading list from 'End of Central Dir' index list...");
        if(!$this->_loadFileListByEOF($fh, $stopOnFile)){
            $this->debugMsg(1, "Failed! Trying to load list looking for signatures...");
            if(!$this->_loadFileListBySignatures($fh, $stopOnFile)){
                $this->debugMsg(1, "Failed! Could not find any valid header.");
                $this->debugMsg(2, "ZIP File is corrupted or empty");
                return false;
            }
        }    
        return $this->compressedList;
    }
    
    // --------------------------------------------------------------------
    /**
     * Unzip file in archive.
     *
     * @access    Public
     * @param     string, boolean
     * @return    Unziped file.
     */    
    Function unzipFile($compressedFileName, $targetFileName=false){
        if(!sizeof($this->compressedList)){
            $this->debugMsg(1, "Trying to unzip before loading file list... Loading it!");
            $this->getList(false, $compressedFileName);
        }
        
        $fdetails = &$this->compressedList[$compressedFileName];
        if(!isset($this->compressedList[$compressedFileName])){
            $this->debugMsg(2, "File '<b>$compressedFileName</b>' is not compressed in the zip.");
            return false;
        }
        if(substr($compressedFileName, -1) == "/"){
            $this->debugMsg(2, "Trying to unzip a folder name '<b>$compressedFileName</b>'.");
            return false;
        }
        if(!$fdetails['uncompressed_size']){
            $this->debugMsg(1, "File '<b>$compressedFileName</b>' is empty.");
            return $targetFileName?
                file_put_contents($targetFileName, ""):
                "";
        }
        
        fseek($this->fh, $fdetails['contents-startOffset']);
        $ret = $this->uncompress(
                fread($this->fh, $fdetails['compressed_size']),
                $fdetails['compression_method'],
                $fdetails['uncompressed_size'],
                $targetFileName
            );
        if($this->applyChmod && $targetFileName)
            chmod($targetFileName, 0644);
        
        return $ret;
    }
    
    // --------------------------------------------------------------------
    /**
     * Unzip all files in archive.
     *
     * @access    Public
     * @param     none
     * @return    none
     */

    Function unzipAll(){
        if($this->targetDir === false)
            $this->debugMsg(2, "No target dir set");
        
        $lista = $this->getList();
        if(sizeof($lista)) 
          foreach($lista as $file=>$trash){
            $dirname  = dirname($file);
            $outDN    = $this->targetDir."/".$dirname;
            
            if(substr($dirname, 0, strlen($this->baseDir)) != $this->baseDir)
                continue;
            
            if(!is_dir($outDN) && $this->maintainStructure){
                $str = "";
                $folders = explode("/", $dirname);
                foreach($folders as $folder){
                    $str = $str?$str."/".$folder:$folder;
                    if(!is_dir($this->targetDir."/".$str)){
                        $this->debugMsg(1, "Creating folder: ".$this->targetDir."/".$str);
                        mkdir($this->targetDir."/".$str);
                        if($this->applyChmod)
                            chmod($this->targetDir."/".$str, $this->applyChmod);
                    }
                }
            }
            if(substr($file, -1, 1) == "/")
                continue;

            $this->maintainStructure?
                $this->unzipFile($file, $this->targetDir."/".$file):
                $this->unzipFile($file, $this->targetDir."/".basename($file));
        }
    }

    // --------------------------------------------------------------------
    /**
     * Free the file resource.
     *
     * @access    Public
     * @param     none
     * @return    none
     */
    
    function close(){     // Free the file resource
        if($this->fh)
            fclose($this->fh);
    }
    // --------------------------------------------------------------------
    /**
     * Free the file resource Automatic destroy.
     *
     * @access    Public
     * @param     none
     * @return    none
     */
    
    function __destroy(){ 
        $this->close();
    }

    // --------------------------------------------------------------------
    /**
     * Show error messages
     *
     * @access    public
     * @param    string
     * @return    string
     */    
    function display_errors($level = 2, $open = '<p>', $close = '</p>')
    {    
        $str = '';
        if($level == 1)
        foreach ($this->info as $val)
        {
            $str .= $open.$val.$close;
        }

        if($level == 2)
        foreach ($this->error as $val)
        {
            $str .= $open.$val.$close;
        }
    
        return $str;
    }
    
    // --------------------------------------------------------------------
    /**
     * Uncompress file. And save it to the targetFile.
     *
     * @access    Private
     * @param     Filecontent, int, int, boolean
     * @return    none
     */
    function uncompress($content, $mode, $uncompressedSize, $targetFileName=false){
        switch($mode){
            case 0:
                return $targetFileName?file_put_contents($targetFileName, $content):$content;
            case 1:
                $this->debugMsg(2, "Shrunk mode is not supported... yet?");
                return false;
            case 2:
            case 3:
            case 4:
            case 5:
                $this->debugMsg(2, "Compression factor ".($mode-1)." is not supported... yet?");
                return false;
            case 6:
                $this->debugMsg(2, "Implode is not supported... yet?");
                return false;
            case 7:
                $this->debugMsg(2, "Tokenizing compression algorithm is not supported... yet?");
                return false;
            case 8:
                // Deflate
                return $targetFileName?
                    file_put_contents($targetFileName, gzinflate($content, $uncompressedSize)):
                    gzinflate($content, $uncompressedSize);
            case 9:
                $this->debugMsg(2, "Enhanced Deflating is not supported... yet?");
                return false;
            case 10:
                $this->debugMsg(2, "PKWARE Date Compression Library Impoloding is not supported... yet?");
                return false;
           case 12:
               // Bzip2
               return $targetFileName?
                   file_put_contents($targetFileName, bzdecompress($content)):
                   bzdecompress($content);
            case 18:
                $this->debugMsg(2, "IBM TERSE is not supported... yet?");
                return false;
            default:
                $this->debugMsg(2, "Unknown uncompress method: $mode");
                return false;
        }
    }
    
    // --------------------------------------------------------------------
    /**
     * Save messages
     *
     * @access    Private
     * @param    string
     * @return    none
     */    

    function debugMsg($level, $string){
            if($level == 1)
                $this->error[] = "<b style='color: #777'>dUnzip2:</b> $string<br>";
            if($level == 2)
                $this->info[] = "<b style='color: #F00'>dUnzip2:</b> $string<br>";
    }
    

    Function _loadFileListByEOF(&$fh, $stopOnFile=false){
        // Check if there's a valid Central Dir signature.
        // Let's consider a file comment smaller than 1024 characters...
        // Actually, it length can be 65536.. But we're not going to support it.
        
        for($x = 0; $x < 1024; $x++){
            fseek($fh, -22-$x, SEEK_END);
            
            $signature = fread($fh, 4);
            if($signature == $this->dirSignatureE){
                // If found EOF Central Dir
                $eodir['disk_number_this']   = unpack("v", fread($fh, 2)); // number of this disk
                $eodir['disk_number']        = unpack("v", fread($fh, 2)); // number of the disk with the start of the central directory
                $eodir['total_entries_this'] = unpack("v", fread($fh, 2)); // total number of entries in the central dir on this disk
                $eodir['total_entries']      = unpack("v", fread($fh, 2)); // total number of entries in
                $eodir['size_of_cd']         = unpack("V", fread($fh, 4)); // size of the central directory
                $eodir['offset_start_cd']    = unpack("V", fread($fh, 4)); // offset of start of central directory with respect to the starting disk number
                $zipFileCommentLenght        = unpack("v", fread($fh, 2)); // zipfile comment length
                $eodir['zipfile_comment']    = $zipFileCommentLenght[1]?fread($fh, $zipFileCommentLenght[1]):''; // zipfile comment
                $this->endOfCentral = Array(
                    'disk_number_this'=>$eodir['disk_number_this'][1],
                    'disk_number'=>$eodir['disk_number'][1],
                    'total_entries_this'=>$eodir['total_entries_this'][1],
                    'total_entries'=>$eodir['total_entries'][1],
                    'size_of_cd'=>$eodir['size_of_cd'][1],
                    'offset_start_cd'=>$eodir['offset_start_cd'][1],
                    'zipfile_comment'=>$eodir['zipfile_comment'],
                );
                
                // Then, load file list
                fseek($fh, $this->endOfCentral['offset_start_cd']);
                $signature = fread($fh, 4);
                
                while($signature == $this->dirSignature){
                    $dir['version_madeby']      = unpack("v", fread($fh, 2)); // version made by
                    $dir['version_needed']      = unpack("v", fread($fh, 2)); // version needed to extract
                    $dir['general_bit_flag']    = unpack("v", fread($fh, 2)); // general purpose bit flag
                    $dir['compression_method']  = unpack("v", fread($fh, 2)); // compression method
                    $dir['lastmod_time']        = unpack("v", fread($fh, 2)); // last mod file time
                    $dir['lastmod_date']        = unpack("v", fread($fh, 2)); // last mod file date
                    $dir['crc-32']              = fread($fh, 4);              // crc-32
                    $dir['compressed_size']     = unpack("V", fread($fh, 4)); // compressed size
                    $dir['uncompressed_size']   = unpack("V", fread($fh, 4)); // uncompressed size
                    $fileNameLength             = unpack("v", fread($fh, 2)); // filename length
                    $extraFieldLength           = unpack("v", fread($fh, 2)); // extra field length
                    $fileCommentLength          = unpack("v", fread($fh, 2)); // file comment length
                    $dir['disk_number_start']   = unpack("v", fread($fh, 2)); // disk number start
                    $dir['internal_attributes'] = unpack("v", fread($fh, 2)); // internal file attributes-byte1
                    $dir['external_attributes1']= unpack("v", fread($fh, 2)); // external file attributes-byte2
                    $dir['external_attributes2']= unpack("v", fread($fh, 2)); // external file attributes
                    $dir['relative_offset']     = unpack("V", fread($fh, 4)); // relative offset of local header
                    $dir['file_name']           = fread($fh, $fileNameLength[1]);                             // filename
                    $dir['extra_field']         = $extraFieldLength[1] ?fread($fh, $extraFieldLength[1]) :''; // extra field
                    $dir['file_comment']        = $fileCommentLength[1]?fread($fh, $fileCommentLength[1]):''; // file comment            
                    
                    // Convert the date and time, from MS-DOS format to UNIX Timestamp
                    $BINlastmod_date = str_pad(decbin($dir['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
                    $BINlastmod_time = str_pad(decbin($dir['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
                    $lastmod_dateY = bindec(substr($BINlastmod_date,  0, 7))+1980;
                    $lastmod_dateM = bindec(substr($BINlastmod_date,  7, 4));
                    $lastmod_dateD = bindec(substr($BINlastmod_date, 11, 5));
                    $lastmod_timeH = bindec(substr($BINlastmod_time,   0, 5));
                    $lastmod_timeM = bindec(substr($BINlastmod_time,   5, 6));
                    $lastmod_timeS = bindec(substr($BINlastmod_time,  11, 5));    
                    
                    $this->centralDirList[$dir['file_name']] = Array(
                        'version_madeby'=>$dir['version_madeby'][1],
                        'version_needed'=>$dir['version_needed'][1],
                        'general_bit_flag'=>str_pad(decbin($dir['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
                        'compression_method'=>$dir['compression_method'][1],
                        'lastmod_datetime'  =>mktime($lastmod_timeH, $lastmod_timeM, $lastmod_timeS, $lastmod_dateM, $lastmod_dateD, $lastmod_dateY),
                        'crc-32'            =>str_pad(dechex(ord($dir['crc-32'][3])), 2, '0', STR_PAD_LEFT).
                                              str_pad(dechex(ord($dir['crc-32'][2])), 2, '0', STR_PAD_LEFT).
                                              str_pad(dechex(ord($dir['crc-32'][1])), 2, '0', STR_PAD_LEFT).
                                              str_pad(dechex(ord($dir['crc-32'][0])), 2, '0', STR_PAD_LEFT),
                        'compressed_size'=>$dir['compressed_size'][1],
                        'uncompressed_size'=>$dir['uncompressed_size'][1],
                        'disk_number_start'=>$dir['disk_number_start'][1],
                        'internal_attributes'=>$dir['internal_attributes'][1],
                        'external_attributes1'=>$dir['external_attributes1'][1],
                        'external_attributes2'=>$dir['external_attributes2'][1],
                        'relative_offset'=>$dir['relative_offset'][1],
                        'file_name'=>$dir['file_name'],
                        'extra_field'=>$dir['extra_field'],
                        'file_comment'=>$dir['file_comment'],
                    );
                    $signature = fread($fh, 4);
                }
                
                // If loaded centralDirs, then try to identify the offsetPosition of the compressed data.
                if($this->centralDirList) foreach($this->centralDirList as $filename=>$details){
                    $i = $this->_getFileHeaderInformation($fh, $details['relative_offset']);
                    $this->compressedList[$filename]['file_name']          = $filename;
                    $this->compressedList[$filename]['compression_method'] = $details['compression_method'];
                    $this->compressedList[$filename]['version_needed']     = $details['version_needed'];
                    $this->compressedList[$filename]['lastmod_datetime']   = $details['lastmod_datetime'];
                    $this->compressedList[$filename]['crc-32']             = $details['crc-32'];
                    $this->compressedList[$filename]['compressed_size']    = $details['compressed_size'];
                    $this->compressedList[$filename]['uncompressed_size']  = $details['uncompressed_size'];
                    $this->compressedList[$filename]['lastmod_datetime']   = $details['lastmod_datetime'];
                    $this->compressedList[$filename]['extra_field']        = $i['extra_field'];
                    $this->compressedList[$filename]['contents-startOffset']=$i['contents-startOffset'];
                    if(strtolower($stopOnFile) == strtolower($filename))
                        break;
                }
                return true;
            }
        }
        return false;
    }
    Function _loadFileListBySignatures(&$fh, $stopOnFile=false){
        fseek($fh, 0);
        
        $return = false;
        for(;;){
            $details = $this->_getFileHeaderInformation($fh);
            if(!$details){
                $this->debugMsg(1, "Invalid signature. Trying to verify if is old style Data Descriptor...");
                fseek($fh, 12 - 4, SEEK_CUR); // 12: Data descriptor - 4: Signature (that will be read again)
                $details = $this->_getFileHeaderInformation($fh);
            }
            if(!$details){
                $this->debugMsg(1, "Still invalid signature. Probably reached the end of the file.");
                break;
            }
            $filename = $details['file_name'];
            $this->compressedList[$filename] = $details;
            $return = true;
            if(strtolower($stopOnFile) == strtolower($filename))
                break;
        }
        
        return $return;
    }
    Function _getFileHeaderInformation(&$fh, $startOffset=false){
        if($startOffset !== false)
            fseek($fh, $startOffset);
        
        $signature = fread($fh, 4);
        if($signature == $this->zipSignature){
        
            // Get information about the zipped file
            $file['version_needed']     = unpack("v", fread($fh, 2)); // version needed to extract
            $file['general_bit_flag']   = unpack("v", fread($fh, 2)); // general purpose bit flag
            $file['compression_method'] = unpack("v", fread($fh, 2)); // compression method
            $file['lastmod_time']       = unpack("v", fread($fh, 2)); // last mod file time
            $file['lastmod_date']       = unpack("v", fread($fh, 2)); // last mod file date
            $file['crc-32']             = fread($fh, 4);              // crc-32
            $file['compressed_size']    = unpack("V", fread($fh, 4)); // compressed size
            $file['uncompressed_size']  = unpack("V", fread($fh, 4)); // uncompressed size
            $fileNameLength             = unpack("v", fread($fh, 2)); // filename length
            $extraFieldLength           = unpack("v", fread($fh, 2)); // extra field length
            $file['file_name']          = fread($fh, $fileNameLength[1]); // filename
            $file['extra_field']        = $extraFieldLength[1]?fread($fh, $extraFieldLength[1]):''; // extra field
            $file['contents-startOffset']= ftell($fh);
            
            // Bypass the whole compressed contents, and look for the next file
            fseek($fh, $file['compressed_size'][1], SEEK_CUR);
            
            // Convert the date and time, from MS-DOS format to UNIX Timestamp
            $BINlastmod_date = str_pad(decbin($file['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
            $BINlastmod_time = str_pad(decbin($file['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
            $lastmod_dateY = bindec(substr($BINlastmod_date,  0, 7))+1980;
            $lastmod_dateM = bindec(substr($BINlastmod_date,  7, 4));
            $lastmod_dateD = bindec(substr($BINlastmod_date, 11, 5));
            $lastmod_timeH = bindec(substr($BINlastmod_time,   0, 5));
            $lastmod_timeM = bindec(substr($BINlastmod_time,   5, 6));
            $lastmod_timeS = bindec(substr($BINlastmod_time,  11, 5));
            
            // Mount file table
            $i = Array(
                'file_name'         =>$file['file_name'],
                'compression_method'=>$file['compression_method'][1],
                'version_needed'    =>$file['version_needed'][1],
                'lastmod_datetime'  =>mktime($lastmod_timeH, $lastmod_timeM, $lastmod_timeS, $lastmod_dateM, $lastmod_dateD, $lastmod_dateY),
                'crc-32'            =>str_pad(dechex(ord($file['crc-32'][3])), 2, '0', STR_PAD_LEFT).
                                      str_pad(dechex(ord($file['crc-32'][2])), 2, '0', STR_PAD_LEFT).
                                      str_pad(dechex(ord($file['crc-32'][1])), 2, '0', STR_PAD_LEFT).
                                      str_pad(dechex(ord($file['crc-32'][0])), 2, '0', STR_PAD_LEFT),
                'compressed_size'   =>$file['compressed_size'][1],
                'uncompressed_size' =>$file['uncompressed_size'][1],
                'extra_field'       =>$file['extra_field'],
                'general_bit_flag'  =>str_pad(decbin($file['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
                'contents-startOffset'=>$file['contents-startOffset']
            );
            return $i;
        }
        return false;
    }
}
?>