<?php
/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Contribution
 */

queue_js_file('contribution-public-form');
queue_js_file('jquery.bxslider.min');
queue_css_file('jquery.bxslider');
$contributionPath = get_option('contribution_page_path');
if(!$contributionPath) {
    $contributionPath = 'contribution';
}
queue_css_file('form');

$head = array('title' => 'Contribute',
              'bodyclass' => 'contribution');
echo head($head); ?>
<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function() {            
enableContributionTypeButtons(<?php echo js_escape(url($contributionPath.'/type-form')); ?>);
});
// ]]>
</script>

<div id="primary">
<?php echo flash(); ?>
    
    <h1><?php echo $head['title']; ?></h1>

    
        <div>
        <?php $options = get_table_options('ContributionType' ); ?>
        <?php array_shift($options); ?>
        <?php foreach($options as $id=>$option): ?>
            <a href='' class='type-option' value='<?php echo $id+1; ?>'><?php echo $option; ?></a>
        <?php endforeach; ?>
        
        </div>

        <?php  if (isset($typeForm)): ?>
        <?php //if (true): ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div id="bx-pager">
              <a data-slide-index="0" href="">Your Contribution</a>
              <a data-slide-index="1" href="">Where and When</a>
              <a data-slide-index="2" href="">Personal Information</a>
              <a data-slide-index="3" href="">Share</a>
            </div>
            
            <input type='hidden' name='contribution_type' value='1' />
            <div id="form-container">
            <ul class="bxslider">
                
                <li>
                    <div class="form">
                        <p>Your Contribution</p>
                        <div id='type-form'>
                            <?php echo $typeForm; ?>
                        </div>
                    </div>
                </li>
                

                <li>
                    <div class="form">
                        <p>Where and When</p>
                            <?php echo get_specific_plugin_hook_output('Geolocation', 'contribution_type_form', array('view' => $this, 'item' => $item, 'type'=>$type) ); ?>
                            <!-- figure out how the calendar will work :) , and do the same thing!   -->
                    </div>

                </li>
                                
                
                <li>
                    <div class="form">
                        <p>Personal Information</p>
                            <?php echo $profileForm; ?>
                            <!-- profile information here -->
                    </div>
                </li>
                
                <li>
                    <div class="form">
                        <p>Share</p>
                        <fieldset id="contribution-confirm-submit" <?php if (!isset($typeForm)) { echo 'style="display: none;"'; }?>>
                        <?php if(get_option('contribution_simple') && !current_user()) : ?>
                            <div class="field">
                                <?php echo $this->formLabel('contribution_simple_email', 'Email (Required)'); ?>
                                <?php echo $this->formText('contribution_simple_email'); ?>
                            </div>
                        <?php endif; ?>
                            <div class="inputs">
                                <?php $public = isset($_POST['contribution-public']) ? $_POST['contribution-public'] : 0; ?>
                                <?php echo $this->formCheckbox('contribution-public', $public, null, array('1', '0')); ?>
                                <?php echo $this->formLabel('contribution-public', 'Publish my contribution on the web.'); ?>
                            </div>
                            <div class="inputs">
                                <?php $anonymous = isset($_POST['contribution-anonymous']) ? $_POST['contribution-anonymous'] : 0; ?>
                                <?php echo $this->formCheckbox('contribution-anonymous', $anonymous, null, array(1, 0)); ?>
                                <?php echo $this->formLabel('contribution-anonymous', "Contribute anonymously."); ?>
                            </div>
                             
                            <div class="inputs">
                                <?php $contactable = isset($_POST['contribution-contactable']) ? $_POST['contribution-contactable'] : 0; ?>
                                <?php echo $this->formCheckbox('contribution-contactable', $contactable, null, array(1, 0)); ?>
                                <?php echo $this->formLabel('contribution-contactable', "May site administrators ask you for more information about this?"); ?>
                            </div>                            
                            <p>In order to contribute, you must read and agree to the <a href="<?php echo contribution_contribute_url('terms') ?>" target="_blank">Terms and Conditions.</a></p>
                            <div class="inputs">
                                <?php $agree = isset( $_POST['terms-agree']) ?  $_POST['terms-agree'] : 0 ?>
                                <?php echo $this->formCheckbox('terms-agree', $agree, null, array('1', '0')); ?>
                                <?php echo $this->formLabel('terms-agree', 'I agree to the Terms and Conditions.'); ?>
                            </div>
                        </fieldset>
                    <?php echo $this->formSubmit('form-submit', 'Contribute', array('class' => 'submitinput')); ?>                           
                    </div>
                </li>
            </ul>
            </div>
        </form>
        
<script>
jQuery('.bxslider').bxSlider({
  infiniteLoop: false,
  hideControlOnEnd: true,
  pagerCustom: '#bx-pager'
});
</script>
        <?php endif; ?>
</div>
<?php echo foot();
