<?php
/**
 * Creator navigation template
 *
 *
 * The Archon API is also available through the variable:
 *
 *  $_ARCHON
 *
 * Refer to the Archon class definition in lib/archon.inc.php
 * for available properties and methods.
 *
 * @package Archon
 * @author Will Martin
 */

isset($_ARCHON) or die();

?>

<h1 id='titleheader'><?php echo($strPageTitle); ?></h1>
   <div class="<?php echo($strSubTitleClasses); ?>"><?php echo($strSubTitle); ?></div><br /><br />
   <div class="bground beginningwith"<?php echo($strBackgroundID); ?>><div class='listitemcover'></div>
		<?php echo($content); ?>
</div>
