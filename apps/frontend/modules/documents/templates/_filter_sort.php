<br />
<?php
echo '<div class="orderform">' . __('Display');

$npp_options = options_for_select(array('10' => 10, '20' => 20, '30' => 30, '40' => 40, '50' => 50, '100' => 100), c2cTools::mobileVersion() ? 20 : 30);
echo select_tag('npp', $npp_options);
echo __('items per page');

$conf = 'mod_' . $sf_context->getModuleName() . '_sort_criteria';
$sort_fields = array_map('translate_sort_param', sfConfig::get($conf));

// First criteria of order
if (!isset($orderby_default))
{
    $orderby_default = '';
}

// add blank option
$html_options = array('include_blank' => true);

// add remapping infos to remap option values
$remapping = sfConfig::get('mod_' . $sf_context->getModuleName() . '_sort_remapping');
if (is_array($remapping))
{
    $html_options['remapping'] = $remapping;
}

// add html attribute for each option
$attribute_list = sfConfig::get('mod_' . $sf_context->getModuleName() . '_sort_attributes');
if (is_array($attribute_list))
{
    $option_attributes = array();
    foreach ($attribute_list as $attribute)
    {
        $option_value_list = sfConfig::get('mod_' . $sf_context->getModuleName() . '_sort_' . $attribute);
        foreach ($option_value_list as $option_value => $attribute_value)
        {
            if (!isset($option_attributes[$option_value]))
            {
                $option_attributes[$option_value] = array();
            }
            $option_attributes[$option_value][$attribute] = $attribute_value;
        }
    }
    $html_options['option_attributes'] = $option_attributes;
}

// orderby tag
$orderby_options = options_for_select_enhanced($sort_fields, $orderby_default, $html_options);
echo select_tag('orderby', $orderby_options);

if (!isset($order_default))
{
    $order_default = '';
}
$order_options = options_for_select(array('asc' => __('ascending'), 'desc' => __('descending')),
                                    $order_default, array('include_blank' => true));
echo select_tag('order', $order_options);

// Second criteria of order
echo '<br />' . __('then by');

if (!empty($orderby_default))
{
    $orderby2_options = options_for_select($sort_fields, '', array('include_blank' => true));
}
else
{
    $orderby2_options = $orderby_options;
}
echo select_tag('orderby2', $orderby2_options);

if (!empty($order_default))
{
    $order2_options = options_for_select(array('asc' => __('ascending'), 'desc' => __('descending')),
                                         '', array('include_blank' => true));
}
else
{
    $order2_options = $order_options;
}
echo select_tag('order2', $order2_options);

echo '</div>';

