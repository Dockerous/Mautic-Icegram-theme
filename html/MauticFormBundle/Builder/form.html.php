<?php

$formName = '_' . $form->generateFormName();
$fields   = $form->getFields();
?>

<?php if ($form->getRenderStyle()) echo $view->render($theme.'MauticFormBundle:Builder:style.html.php', array('form' => $form, 'formName' => $formName)); ?>
<div id="mauticform_wrapper<?php echo $formName ?>" class="mauticform_wrapper " data-formid = "mauticform_wrapper<?php echo $formName ?>">
    <style type="text/css">.ig_form_left.ig_form_style_4 .ig_form_container:before{ display:none;}</style>
    <form autocomplete="false" role="form" method="post" class="ig_clear_fix" action="<?php echo $view['router']->url('mautic_form_postresults', array('formId' => $form->getId())); ?>" id="mauticform<?php echo $formName ?>" data-mautic-form="<?php echo ltrim($formName, '_') ?>">
        <div class="mauticform-error" id="mauticform<?php echo $formName ?>_error"></div>
        <div class="mauticform-message" id="mauticform<?php echo $formName ?>_message"></div>
        <div class="mauticform-innerform ig_embed_form_container ig_clear_fix ig_quater">
            
<?php
$last_visible = NULL;
foreach($fields as $i => $f){
    if($fields[$i]->getType() != 'hidden'){
        $last_visible = $i;
    }
}
$n = 0;
foreach($fields as $i => $f){
    $add_class = "";
    if($n == 0){
        $add_class = " ig_form_els_first";
    }  elseif ($last_visible !== NULL && $i == $last_visible) {
        $add_class = " ig_form_els_last";
    }
    $n++;
    if($f->getType() != 'hidden'){
        echo '<div class="ig_form_els'.$add_class.'">';
    }else{
        echo '<div class="" style="display: none;"';
    }
    if ($f->isCustom()):
        $params = $f->getCustomParameters();
        $template = $params['template'];
    else:
        $template = 'MauticFormBundle:Field:' . $f->getType() . '.html.php';
    endif;

    echo $view->render($theme.$template, array('field' => $f->convertToArray(), 'id' => $f->getAlias(), 'formName' => $formName));
    echo "</div>";
}
?>


            <input type="hidden" name="mauticform[formId]" id="mauticform<?php echo $formName ?>_id" value="<?php echo $form->getId(); ?>" />
            <input type="hidden" name="mauticform[return]" id="mauticform<?php echo $formName ?>_return" value="" />
            <input type="hidden" name="mauticform[formName]" id="mauticform<?php echo $formName ?>_name" value="<?php echo ltrim($formName, '_'); ?>" />

        </div>
    </form>
</div>