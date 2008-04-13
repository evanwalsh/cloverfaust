<h3>Post formatting</h3>
<p>All posts on cloverfaust are formatted with the Textile markup language.  Here is how it all works:</p>
<pre>
Block modifier syntax:

Header: h(1-6).
Paragraphs beginning with 'hn. ' (where n is 1-6) are wrapped in header tags.
Example: h1. Header... -&gt; &lt;h1&gt;Header...&lt;/h1&gt;

Paragraph: p. (also applied by default)
Example: p. Text -&gt; &lt;p&gt;Text&lt;/p&gt;

Blockquote: bq.
Example: bq. Block quotation... -&gt; &lt;blockquote&gt;Block quotation...&lt;/blockquote&gt;

Blockquote with citation: bq.:http://citation.url
Example: bq.:http://textism.com/ Text...
-&gt;  &lt;blockquote cite="http://textism.com"&gt;Text...&lt;/blockquote&gt;

Footnote: fn(1-100).
Example: fn1. Footnote... -&gt; &lt;p id="fn1"&gt;Footnote...&lt;/p&gt;

Numeric list: #, ##
Consecutive paragraphs beginning with # are wrapped in ordered list tags.
Example: &lt;ol&gt;&lt;li&gt;ordered list&lt;/li&gt;&lt;/ol&gt;

Bulleted list: *, **
Consecutive paragraphs beginning with * are wrapped in unordered list tags.
Example: &lt;ul&gt;&lt;li&gt;unordered list&lt;/li&gt;&lt;/ul&gt;

Phrase modifier syntax:

       _emphasis_   -&gt;   &lt;em&gt;emphasis&lt;/em&gt;
       __italic__   -&gt;   &lt;i&gt;italic&lt;/i&gt;
         *strong*   -&gt;   &lt;strong&gt;strong&lt;/strong&gt;
         **bold**   -&gt;   &lt;b&gt;bold&lt;/b&gt;
     ??citation??   -&gt;   &lt;cite&gt;citation&lt;/cite&gt;
   -deleted text-   -&gt;   &lt;del&gt;deleted&lt;/del&gt;
  +inserted text+   -&gt;   &lt;ins&gt;inserted&lt;/ins&gt;
    ^superscript^   -&gt;   &lt;sup&gt;superscript&lt;/sup&gt;
      ~subscript~   -&gt;   &lt;sub&gt;subscript&lt;/sub&gt;
           @code@   -&gt;   &lt;code&gt;computer code&lt;/code&gt;
      %(bob)span%   -&gt;   &lt;span class="bob"&gt;span&lt;/span&gt;

    ==notextile==   -&gt;   leave text alone (do not format)

   "linktext":url   -&gt;   &lt;a href="url"&gt;linktext&lt;/a&gt;
"linktext(title)":url  -&gt;   &lt;a href="url" title="title"&gt;linktext&lt;/a&gt;

       !imageurl!   -&gt;   &lt;img src="imageurl" /&gt;
!imageurl(alt text)!  -&gt;   &lt;img src="imageurl" alt="alt text" /&gt;
!imageurl!:linkurl  -&gt;   &lt;a href="linkurl"&gt;&lt;img src="imageurl" /&gt;&lt;/a&gt;

ABC(Always Be Closing)  -&gt;   &lt;acronym title="Always Be Closing"&gt;ABC&lt;/acronym&gt;


Table syntax:

Simple tables:

    |a|simple|table|row|
    |And|Another|table|row|

    |_. A|_. table|_. header|_.row|
    |A|simple|table|row|

Tables with attributes:

    table{border:1px solid black}.
    {background:#ddd;color:red}. |{}| | | |


Applying Attributes:

Most anywhere Textile code is used, attributes such as arbitrary css style,
css classes, and ids can be applied. The syntax is fairly consistent.

The following characters quickly alter the alignment of block elements:

    &lt;  -&gt;  left align    ex. p&lt;. left-aligned para
    &gt;  -&gt;  right align       h3&gt;. right-aligned header 3
    =  -&gt;  centred           h4=. centred header 4
    &lt;&gt; -&gt;  justified         p&lt;&gt;. justified paragraph

These will change vertical alignment in table cells:

    ^  -&gt;  top         ex. |^. top-aligned table cell|
    -  -&gt;  middle          |-. middle aligned|
    ~  -&gt;  bottom          |~. bottom aligned cell|

Plain (parentheses) inserted between block syntax and the closing dot-space
indicate classes and ids:

    p(hector). paragraph -&gt; &lt;p class="hector"&gt;paragraph&lt;/p&gt;

    p(#fluid). paragraph -&gt; &lt;p id="fluid"&gt;paragraph&lt;/p&gt;

    (classes and ids can be combined)
    p(hector#fluid). paragraph -&gt; &lt;p class="hector" id="fluid"&gt;paragraph&lt;/p&gt;

Curly {brackets} insert arbitrary css style

    p{line-height:18px}. paragraph -&gt; &lt;p style="line-height:18px"&gt;paragraph&lt;/p&gt;

    h3{color:red}. header 3 -&gt; &lt;h3 style="color:red"&gt;header 3&lt;/h3&gt;

Square [brackets] insert language attributes

    p[no]. paragraph -&gt; &lt;p lang="no"&gt;paragraph&lt;/p&gt;

    %[fr]phrase% -&gt; &lt;span lang="fr"&gt;phrase&lt;/span&gt;

Usually Textile block element syntax requires a dot and space before the block
begins, but since lists don't, they can be styled just using braces

    #{color:blue} one  -&gt;  &lt;ol style="color:blue"&gt;
    # big                   &lt;li&gt;one&lt;/li&gt;
    # list                  &lt;li&gt;big&lt;/li&gt;
                            &lt;li&gt;list&lt;/li&gt;
                           &lt;/ol&gt;

Using the span tag to style a phrase

    It goes like this, %{color:red}the fourth the fifth%
          -&gt; It goes like this, &lt;span style="color:red"&gt;the fourth the fifth&lt;/span&gt;

</pre>

<h3>Invites</h3>
<p>Each user is given one invite upon account creation.  After that invite is used, that's it.  No invites for you!</p>

<h3>Who did this?</h3>
<p>This whole site was coded and designed by <a href="http://nothingconcept.com">Evan Walsh</a> as a side project.  Who knows where it's going?  Probably nowhere.  Sigh.</p>