<?php $this->start('css');
echo $this->Html->css('users_managemembers');
$this->end(); ?>

<h3 class="title">Add New Member</h3>
<?php echo $this->Form->create("User", array("type" => "file")); ?>
<?php echo $this->Form->hidden("User.id"); ?>
<?php echo $this->Form->hidden("User.profile_picture"); ?>
<?php echo $this->Form->input("User.picture_file", array("label" => "Select Profile Picture", "type" => "file")); ?>
<?php echo $this->Form->input("User.email"); ?>
<?php echo $this->Form->input("User.first_name"); ?>
<?php echo $this->Form->input("User.last_name"); ?>
<?php echo $this->Form->input("User.department"); ?>
<?php echo $this->Form->input("User.position"); ?>
<?php echo $this->Form->input('User.title', array('label' => 'Title <span class=\'optional\'>Optional</span>')); ?>
<?php echo $this->Form->input("User.city"); ?>
<?php echo $this->Form->input("User.state_id", array("options" => $states)); ?>
<?php echo $this->Form->input("User.zip"); ?>
<?php echo $this->Form->input("User.country_id", array("options" => $countries)); ?>
<?php echo $this->Form->end("Add New Member"); ?>