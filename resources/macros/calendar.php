<?php

HTML::macro('calendar', function($field,$value,$time = false)
{
    return '<input type="text" id="'.$field.'" name="'.$field.'" class="form-control" value="'.$value.'">';
});


?>