<?php
    $fieldLabel = trans('SimpleWorkflowLang::fields.' . $fieldName);
    $fieldDetails = getFieldDetailsByName($fieldName);
    if ($fieldDetails) {
        $fieldAttributes = json_decode($fieldDetails->attributes ?? '');
    }
    $fieldType = isset($fieldDetails->type) ? $fieldDetails->type : null;
    $fieldStyle = isset($fieldAttributes->style) ? $fieldAttributes->style : null;
    $fieldScript = isset($fieldAttributes->script) ? $fieldAttributes->script : null;
    $fieldPlaceholder = isset($fieldAttributes->placeholder) ? $fieldAttributes->placeholder : null;
    $fieldOptions = isset($fieldAttributes->options) ? $fieldAttributes->options : null;
    $fieldQuery = isset($fieldAttributes->query) ? $fieldAttributes->query : null;
    $fieldDatalist = isset($fieldAttributes->datalist_from_database) ? $fieldAttributes->datalist_from_database : null;
    $fieldClass = isset($fieldAttributes->class) ? $fieldAttributes->class : 'form-control';
?>
<?php if($fieldDetails->type == 'title'): ?>
    <?php echo Form::title($fieldId, [
        'value' => $fieldValue,
        'class' => '',
        'id' => $fieldId,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'hidden'): ?>
    <?php echo Form::hidden($fieldId, [
        'value' => $fieldValue,
        'class' => '',
        'id' => $fieldId,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'help'): ?>
    <?php echo Form::help($fieldId, [
        'options' => isset($fieldAttributes?->options) ? $fieldAttributes?->options : null,
        'class' => '',
        'id' => $fieldDetails->id ?? $fieldId,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'location'): ?>
    <?php
        $defaultLat = isset($variables) ? $variables->where('key', $field->fieldName . '_lat')->first()?->value : null;
        $defaultLng = isset($variables) ? $variables->where('key', $field->fieldName . '_lng')->first()?->value : null;
    ?>
    <?php echo Form::location($fieldId, [
        'value' => $fieldValue,
        'class' => '',
        'id' => $fieldId,
        'required' => $required,
        'readonly' => $readOnly,
        'defaultZoom' => 13,
        'defaultLat' => $defaultLat,
        'defaultLng' => $defaultLng,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'string'): ?>
    <?php echo Form::text($fieldId, [
        'value' => $fieldValue,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
        'datalist_from_database' => isset($fieldAttributes?->datalist_from_database)
            ? $fieldAttributes?->datalist_from_database
            : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'checkbox'): ?>
    <?php echo Form::checkbox($fieldId, [
        'value' => $fieldValue,
        'class' => '',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'text'): ?>
    <?php echo Form::textarea($fieldId, [
        'value' => $fieldValue,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'date'): ?>
    <?php echo Form::date($fieldName, [
        'id' => $fieldId,
        'value' => $fieldValue,
        'altValue' => $fieldValueAlt ?? '',
        'class' => 'form-control',
        'id' => $fieldId,
        'showLabel' => isset($showLabel) ? $showLabel : true,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'time'): ?>
    <?php echo Form::time($fieldId, [
        'value' => $fieldValue,
        'class' => 'form-control timepicker',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'datetime'): ?>
    <?php echo Form::datetime($fieldId, [
        'value' => $fieldValue,
        'valueAlt' => $fieldValueAlt ?? '',
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'select'): ?>
    <?php echo Form::select($fieldId, is_string($fieldAttributes?->options) ? $fieldAttributes?->options : null, [
        'value' => $fieldValue,
        'query' => is_string($fieldAttributes?->query) ? $fieldAttributes?->query : null,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'select-simple'): ?>
    <?php echo Form::selectSimple($fieldId, is_string($fieldAttributes?->options) ? $fieldAttributes?->options : null, [
        'value' => $fieldValue,
        'query' => is_string($fieldAttributes?->query) ? $fieldAttributes?->query : null,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'select-multiple'): ?>
    <?php echo Form::selectMultiple($fieldId, is_string($fieldAttributes?->options) ? $fieldAttributes?->options : null, [
        'value' => json_decode($fieldValue ?? ''),
        'query' => is_string($fieldAttributes?->query) ? $fieldAttributes?->query : null,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type === 'searchable-input'): ?>
    <?php echo Form::searchableInput($fieldId, [
        'value' => $fieldValue,
        'endpoint' => isset($fieldAttributes->endpoint) && is_string($fieldAttributes->endpoint)
            ? $fieldAttributes->endpoint
            : null,
        'minChars' => isset($fieldAttributes->minChars) ? $fieldAttributes->minChars : null,
        'limit' => isset($fieldAttributes->limit) ? $fieldAttributes->limit : null,
        'initial_label' => $fieldAttributes->initial_label ?? ($fieldAttributes->initialLabel ?? null),
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldPlaceholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => $fieldStyle,
        'script' => $fieldScript,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'file'): ?>
    
    <?php echo Form::file($fieldId, [
        'value' => $fieldValue ?? [],
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>

<?php if($fieldDetails->type == 'file-uploader'): ?>
    <link href="<?php echo e(asset('vendor/form-builder/css/file-uploader-field.css')); ?>" rel="stylesheet">
    <div class="file-uploader-field" id="<?php echo e($fieldId); ?>_wrapper" style="<?php echo e(isset($fieldAttributes?->style) ? $fieldAttributes?->style : null); ?>">
        <?php if(!empty($fieldValue)): ?>
            <input type="hidden" name="<?php echo e($fieldId); ?>" value="<?php echo e($fieldValue); ?>">
            <div class="file-uploader-existing mb-2">
                <span class="file-uploader-name"><?php echo e($fieldValue); ?></span>
                <?php if(!$readOnly): ?>
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFileUploader('<?php echo e($fieldId); ?>')">حذف فایل</button>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <input type="hidden" name="<?php echo e($fieldId); ?>" id="<?php echo e($fieldId); ?>" value="">
        <?php endif; ?>

        <?php if($readOnly != 'on'): ?>
            <div class="file-uploader-input-area mb-2">
                <input type="file" id="<?php echo e($fieldId); ?>_input" accept="<?php echo e(isset($fieldAttributes->accepted_files) ? $fieldAttributes->accepted_files : '*'); ?>" class="form-control <?php echo e($required ? 'is-required' : ''); ?>" <?php echo e($required ? 'required' : ''); ?>>
                <button type="button" class="btn btn-primary ms-2 mt-2" onclick="startFileUpload('<?php echo e($fieldId); ?>')">بارگذاری فایل</button>
            </div>
        <?php endif; ?>

        <div id="<?php echo e($fieldId); ?>_progress" class="progress" style="display:none; height: 6px; margin-top: 8px;">
            <div id="<?php echo e($fieldId); ?>_bar" class="progress-bar bg-primary" role="progressbar" style="height: 5px;width: 0%"></div>
        </div>
        <div id="<?php echo e($fieldId); ?>_msg" class="mt-2"></div>
    </div>

    <script>
    function startFileUpload(fieldId) {
        var input = document.getElementById(fieldId + '_input');
        var progress = document.getElementById(fieldId + '_progress');
        var bar = document.getElementById(fieldId + '_bar');
        var msg = document.getElementById(fieldId + '_msg');

        if (!input || !input.files.length) {
            msg.innerHTML = '<span class="text-danger">لطفاً فایلی انتخاب کنید.</span>';
            return;
        }

        var formData = new FormData();
        formData.append('file', input.files[0]);

        progress.style.display = 'block';
        bar.style.width = '0%';
        msg.innerHTML = '';

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo e(route('file.upload')); ?>', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '<?php echo e(csrf_token()); ?>');

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 100);
                bar.style.width = pct + '%';
            }
        };

        xhr.onload = function() {
            progress.style.display = 'none';
            if (xhr.status === 200) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.url) {
                        var hidden = document.querySelector('input[name="' + fieldId + '"]');
                        if (hidden) hidden.value = res.url;
                        var wrapper = document.getElementById(fieldId + '_wrapper');
                        var existing = wrapper.querySelector('.file-uploader-existing');
                        if (existing) existing.remove();
                        var html = '<div class="file-uploader-existing mb-2">' +
                            '<span class="file-uploader-name">' + res.url + '</span>' +
                            '<button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeFileUploader(\'' + fieldId + '\')">حذف فایل</button>' +
                            '</div>';
                        wrapper.insertAdjacentHTML('afterbegin', html);
                        input.style.display = 'none';
                        msg.innerHTML = '<span class="text-success">فایل با موفقیت بارگذاری شد.</span>';
                    } else {
                        msg.innerHTML = '<span class="text-danger">خطا در بارگذاری فایل.</span>';
                    }
                } catch (e) {
                    msg.innerHTML = '<span class="text-danger">پاسخ نامعتبر از سرور.</span>';
                }
            } else {
                msg.innerHTML = '<span class="text-danger">خطا در بارگذاری فایل (کد ' + xhr.status + ').</span>';
            }
        };

        xhr.onerror = function() {
            progress.style.display = 'none';
            msg.innerHTML = '<span class="text-danger">خطا در برقراری اتصال با سرور.</span>';
        };

        xhr.send(formData);
    }

    function removeFileUploader(fieldId) {
        var hidden = document.querySelector('input[name="' + fieldId + '"]');
        if (hidden) hidden.value = '';
        var existing = document.querySelector('#' + fieldId + '_wrapper .file-uploader-existing');
        if (existing) existing.remove();
        var input = document.getElementById(fieldId + '_input');
        if (input) {
            input.style.display = 'block';
            input.value = '';
        }
        var msg = document.getElementById(fieldId + '_msg');
        if (msg) msg.innerHTML = '';
    }
    </script>
<?php endif; ?>
<?php if($fieldDetails->type == 'signature'): ?>
    <?php echo Form::signature($fieldId, [
        'value' => $fieldValue,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
        'datalist_from_database' => isset($fieldAttributes?->datalist_from_database)
            ? $fieldAttributes?->datalist_from_database
            : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'entity'): ?>
    <?php echo Form::entity($fieldId, [
        'columns' => is_string($fieldAttributes?->columns) ? $fieldAttributes?->columns : null,
        'query' => is_string($fieldAttributes?->query) ? $fieldAttributes?->query : null,
        'class' => 'form-control',
        'id' => $fieldAttributes?->id,
        'required' => $required,
        'readonly' => $readOnly,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'button'): ?>
    <?php echo Form::button($fieldName, [
        'class' => $fieldClass,
        'id' => $fieldAttributes?->id ?? $fieldName,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>
<?php if($fieldDetails->type == 'view-model'): ?>
    <?php echo Form::viewModel($fieldId, [
        'class' => $fieldClass,
        'id' => $fieldId,
        'view_model_id' => $fieldAttributes?->view_model_id,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
    ]); ?>

<?php endif; ?>

<?php if($fieldDetails->type == 'formatted-digit'): ?>
    <?php echo Form::formattedDigit($fieldId, [
        'value' => $fieldValue,
        'class' => 'form-control',
        'id' => $fieldId,
        'placeholder' => $fieldAttributes?->placeholder,
        'required' => $required,
        'readonly' => $readOnly,
        'showLabel' => isset($showLabel) ? $showLabel : false,
        'style' => isset($fieldAttributes?->style) ? $fieldAttributes?->style : null,
        'script' => isset($fieldAttributes?->script) ? $fieldAttributes?->script : null,
        'datalist_from_database' => isset($fieldAttributes?->datalist_from_database)
            ? $fieldAttributes?->datalist_from_database
            : null,
    ]); ?>

<?php endif; ?>
<?php /**PATH /var/www/packages/behin-simple-workflow-g1/src/Views/Core/Form/field-generator.blade.php ENDPATH**/ ?>