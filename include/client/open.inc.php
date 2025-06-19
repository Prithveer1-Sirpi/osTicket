<?php
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
    $info=array('name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhoneNumber());
}

$info=($_POST && $errors)?Format::htmlchars($_POST):$info;

$form = null;
if (!$info['topicId']) {
    if (array_key_exists('topicId',$_GET) && preg_match('/^\d+$/',$_GET['topicId']) && Topic::lookup($_GET['topicId']))
        $info['topicId'] = intval($_GET['topicId']);
    else
        $info['topicId'] = $cfg->getDefaultTopicId();
}

$forms = array();
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
    foreach ($topic->getForms() as $F) {
        if (!$F->hasAnyVisibleFields())
            continue;
        if ($_POST) {
            $F = $F->instanciate();
            $F->isValidForClient();
        }
        $forms[] = $F->getForm();
    }
}

?>
<h1 style="text-decoration: none; padding:0rem 1.3rem; background-clip: text; font-family: Helvetica Neue" ><?php echo __('Submit a Request');?></h1>
<!-- <p><?php echo __('Please fill in the form below to open a new ticket.');?></p> -->
<form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data" style="font-family: Open Sans, Helvetica, Arial, sans-serif; padding: 1rem">
    <?php csrf_token(); ?>
    <input type="hidden" name="a" value="open">

    <div style="display: flex; flex-wrap: wrap; gap: 2rem; font-family:Avenir">
        <div style="flex: 1; min-width: 300px; display:flex; flex-direction:column; gap:1rem">
            <!-- Name -->
            <div style="margin-bottom: 1rem;">
                <label for="name" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php echo __('Name'); ?> <span style="color:red">*</span></label>
                <input type="text" name="name" id="name" value="<?php echo $info['name']; ?>" class="green-focus-input" placeholder="Enter Full Name"
                    style="width: 90%; padding: 10px; border: 1px solid #ccc; border-radius: 999px;">
            </div>

            <!-- Email -->
            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php echo __('Email ID'); ?> <span style="color:red">*</span></label>
                <input type="email" name="email" id="email" value="<?php echo $info['email']; ?>" placeholder="Enter Email ID"
                    style="width: 90%; padding: 10px; border: 1px solid #ccc; border-radius: 999px;">
            </div>

            <!-- Topic Dropdown -->
            <div style="margin-bottom: 1rem;">
                <label for="topicId" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php echo __('Reason'); ?> <span style="color:red">*</span></label>
                <select id="topicId" name="topicId"
                style="width: 93%; padding: 10px; border: 1px solid #ccc; border-radius: 999px;
                   background-color: #fff;
                    background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'8\'><path fill=\'%23333\' d=\'M6 8L0 0h12z\'/></svg>');
                    background-repeat: no-repeat;
                    background-position: right 1rem center;
                    background-size: 0.65rem;
                    appearance: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    transition: border-color 0.3s ease;"
                    >
                    <option value="" selected>&mdash; <?php echo __('Select a Help Topic');?> &mdash;</option>
                    <?php
                    if($topics=Topic::getPublicHelpTopics()) {
                        foreach($topics as $id =>$name) {
                            echo sprintf('<option value="%d" %s>%s</option>',
                                    $id, ($info['topicId']==$id)?'selected="selected"':'', $name);
                        }
                    } ?>
                </select>
                <font class="error"><?php echo $errors['topicId']; ?></font>
            </div>

            <!-- Subject -->
            <div style="margin-bottom: 1rem;">
                <label for="subject" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php echo __('Subject'); ?></label>
                <input type="text" name="subject" id="subject" placeholder="Enter Subject"
                    style="width: 90%; padding: 10px; border: 1px solid #ccc; border-radius: 999px;">
            </div>
        </div>

        <!-- Message Textarea (Right side) -->
        <div style="flex: 1; min-width: 300px;">
       <div class="form-right" style="flex: 1; min-width: 320px;">
      <?php
        // Always show the Issue/Message field
        $messageField = TicketForm::objects()->one()->getField('message');
        if ($messageField) {
            echo '<div class="form-group">';
            echo '<label for="message"><b>' . __('Issue') . '</b><span class="error">*</span></label>';
            $messageField->render(array('client'=>true));
            echo '</div>';
        }
      ?>
      <small class="form-helper-text">
        Please enter the details of your request and, if you have any questions regarding our Terms of use, please include specific samples of the usage you wish to give our resources. If you're reporting a problem, make sure to include as much information as possible.
      </small>
    </div>
  </div>
    </div>

    <!-- Dynamic Form (optional fields from selected Topic) -->
    <div id="dynamic-form" style="margin-top: 2rem;">
        <?php
        $options = array('mode' => 'create');
        foreach ($forms as $form) {
            include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
        } ?>
    </div>

    <!-- Submit Button -->
    <div style="text-align: right; margin-top: 2rem;">
        <button type="submit"
            style="background-color: #00a651; color: white; border: black; padding: 10px 30px; border-radius: 999px; font-weight: bold; cursor: pointer;">
            <?php echo __('Submit Request'); ?>
        </button>
    </div>
</form>
