
<?php if (!$type): ?>
<p>You must choose a contribution type to continue.</p>
<?php else: ?>
<h2>Contribute a <?php echo $type->display_name; ?></h2>

<?php 
if ($type->isFileRequired()):
    $required = true;
endif;
?>



<div class="field">
        <?php echo $this->formLabel('contributed_file', 'Upload a file'); ?>
        <?php echo $this->formFile('contributed_file', array('class' => 'fileinput')); ?>
</div>

<?php endif; ?>

<?php 


$this->profileForm = '';
//put the prompts used for profile information in this array
$profilePrompts = array(

        
        );
?>

<?php 
foreach ($type->getTypeElements() as $contributionTypeElement) {
    if(in_array( $contributionTypeElement->prompt, $profilePrompts)) {
        $this->profileForm .= $this->elementForm($contributionTypeElement->Element, $item, array('contributionTypeElement'=>$contributionTypeElement));
    } else {
        echo $this->elementForm($contributionTypeElement->Element, $item, array('contributionTypeElement'=>$contributionTypeElement));        
    }
}
?>

<?php 
if (!isset($required) && $type->isFileAllowed()):
?>

<div id="file" class="field">
        <?php echo $this->formLabel('contributed_file', 'Upload a file (Optional)'); ?>
        <?php echo $this->formFile('contributed_file', array('class' => 'fileinput')); ?>
</div>
<?php endif; ?>

<?php $user = current_user(); ?>
<?php if(get_option('contribution_simple') && !current_user()) : ?>
<div class="field">
    <?php echo $this->formLabel('contribution_simple_email', 'Email (Required)'); ?>
    <?php echo $this->formText('contribution_simple_email'); ?>
</div>
<?php endif; ?>
