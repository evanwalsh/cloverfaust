Hey, the installer works.

<form action="<?=base_url()?>install/one" method="post">
<p>Name: <input type="text" name="name"/></p>
<p>Subtitle: <input type="text" name="subtitle"/></p>
<p>DB host: <input type="text" name="dbhost" value="localhost"/></p>
<p>DB user: <input type="text" name="dbuser"/></p>
<p>DB pass: <input type="text" name="dbpass"/></p>
<p>DB: <input type="text" name="db"/></p>
<p>DB prefix: <input type="text" name="dbprefix"/></p>
<p>First forum name: <input type="text" name="forum"/></p>
</form>