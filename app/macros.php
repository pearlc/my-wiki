<?php

/**
 * Custom Macros
 *
 * @author : Jinho Chung
 */

Form::macro('labelWithCheckbox', function($text, $name, $value, $checked, $labelOptions, $checkboxOptions)
{
    $checkedString = $checked ? ('checked="checked"') : "";

    $nameString = $name ? 'name="' . $name . '"' : "";
    $valueString = $value ? 'value="' . $value . '"' : "";

    $labelOptionString = isset($labelOptions['class']) ? 'class="' . $labelOptions['class'] . '"' : "";
    $labelOptionString .= ' ';
    $labelOptionString .= isset($labelOptions['id']) ? 'id="' . $labelOptions['id'] . '"' : "";

    $checkboxOptionString = isset($checkboxOptions['class']) ? 'class="' . $checkboxOptions['class'] . '"' : "";
    $checkboxOptionString .= ' ';
    $checkboxOptionString .= isset($checkboxOptions['id']) ? 'id="' . $checkboxOptions['id'] . '"' : "";

    return '<label ' . $labelOptionString .'><input type="checkbox" ' . $nameString . ' ' . $valueString . ' ' . $checkedString . ' ' .$checkboxOptionString . ' >' . $text . '</label>';
});
