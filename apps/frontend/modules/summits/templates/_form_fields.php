<?php
use_helper('Object', 'Language', 'Validation', 'MyForm');
$response = sfContext::getInstance()->getResponse();
$response->addJavascript('/static/js/summits_edit.js', 'last');

// Here document = summit
echo '<div>';
display_document_edit_hidden_tags($document, array('v4_id'));
echo '</div>';
echo mandatory_fields_warning(array(('summit form warning')));

include_partial('documents/language_field', array('document'     => $document,
                                                  'new_document' => $new_document));
echo object_group_tag($document, 'name', array('class' => 'long_input'));

echo form_section_title('Information', 'form_info', 'preview_info');

include_partial('documents/oam_coords', array('document' => $document)); // lon, lat fields + OAM map
echo object_group_tag($document, 'elevation', array('suffix' => 'meters', 'class' => 'short_input', 'type' => 'number'));
echo object_group_tag($document, 'maps_info', array('class' => 'medium2_input'), true, null, null, '', true);
echo object_group_dropdown_tag($document, 'summit_type', 'app_summits_summit_types');
?>
<div data-summit_type-filter="1 2">
<?php
echo object_group_tag($document, 'prominence',
    array('suffix' => 'meters', 'class' => 'short_input', 'type' => 'number',
          'label_name' => array(array('label_name' => 'prominence', 'options' => array('data-summit_type-filter' => 1)),
                                array('label_name' => 'summit_deepness', 'options' => array('data-summit_type-filter' => 2)))));
?>
</div>
<?php

echo form_section_title('Description', 'form_desc', 'preview_desc');

echo object_group_bbcode_tag($document, 'description', null, array('class' => 'largetext', 'abstract' => true));

include_partial('documents/form_history');
?>
