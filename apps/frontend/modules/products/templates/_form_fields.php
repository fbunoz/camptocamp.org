<?php
use_helper('Object', 'Language', 'Validation', 'MyForm');

// Here document = product
echo '<div>';
display_document_edit_hidden_tags($document);
echo '</div>';
echo mandatory_fields_warning();

include_partial('documents/language_field', array('document'     => $document,
                                                  'new_document' => $new_document));
echo object_group_tag($document, 'name', null, '', array('class' => 'long_input'));

echo form_section_title('Information', 'form_info', 'preview_info');

include_partial('documents/oam_coords', array('document' => $document));
echo object_group_tag($document, 'elevation', null, 'meters', array('class' => 'short_input'));
echo object_group_dropdown_tag($document, 'product_type', 'mod_products_types_list', array('multiple' => true));
echo object_group_tag($document, 'url', null, '', array('class' => 'long_input'));

echo form_section_title('Description', 'form_desc', 'preview_desc');

echo object_group_bbcode_tag($document, 'description', null, array('class' => 'mediumtext'));
echo object_group_bbcode_tag($document, 'hours', null, array('no_img' => true));
echo object_group_bbcode_tag($document, 'access');

include_partial('documents/form_history');
?>