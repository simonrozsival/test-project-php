<?php

function createInput($name, $label, $type, $values, $errors) {
?>
    <div class="form-group <?=array_key_exists($name, $errors) ? 'has-error' : ''?>">
        <label for="<?=$name?>" class="col-sm-3 control-label"><?=$label?>:</label>
        <div class="col-sm-6">
            <input
                type="<?=$type?>"
                required
                name="<?=$name?>"
                input="text"
                id="<?=$name?>"
                class="form-control"
                <? if(array_key_exists($name, $values)): ?>
                value="<?=htmlspecialchars($values[$name])?>"
                <? endif ?>
            />

            <? if(array_key_exists($name, $errors)): ?>
            <span class="help-block"><?=htmlspecialchars($errors[$name])?></span>
            <? endif ?>
        </div>
    </div>
<?php
}
