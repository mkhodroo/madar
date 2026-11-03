<?php
    $mode = isset($mode) ? $mode : null;
    $content = json_decode($form->content ?? '');
    $content = collect($content)->sortBy('order')->toArray();
?>
<script src="<?php echo e(url('behin/behin-dist/dist/js/signature_pad.umd.min.js')); ?>"></script>
<div class="row col-sm-12 p-0 m-0 dynamic-form" id="<?php echo e($form->id); ?>">
    <?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $fieldLabel = trans('SimpleWorkflowLang::fields.' . $field->fieldName);
            $fieldName = $field->fieldName;
            $fieldClass = $field->class;
            $fieldId = $field->fieldName;
            $required = $field->required;
            $readOnly = $mode ? $mode : $field->readOnly;
            $fieldDetails = getFieldDetailsByName($field->fieldName);
            if ($fieldDetails) {
                $fieldAttributes = json_decode($fieldDetails->attributes ?? '');
                $fieldValue = isset($case) ? $case->getVariable($field->fieldName) : null;
                $fieldValueAlt = (isset($case) and in_array($fieldDetails->type, ['datetime', 'date'])) ? $case->getVariable($field->fieldName . '_alt') : null;
            } else {
                if ($field->fieldName != $form->id) {
                    $childForm = getFormInformation($field->fieldName);
                }
            }
        ?>

        <?php if($fieldDetails): ?>
            <div class="<?php echo e($fieldClass); ?>">
                <?php echo $__env->make('SimpleWorkflowView::Core.Form.field-generator', [
                    'fieldName' => $fieldName,
                    'fieldId' => $fieldId,
                    'fieldClass' => $fieldClass,
                    'readOnly' => $readOnly,
                    'required' => $required,
                    'fieldValue' => $fieldValue,
                    'fieldValueAlt' => $fieldValueAlt ?? '',
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php else: ?>
            <?php if(isset($childForm)): ?>
                <?php echo $__env->make('SimpleWorkflowView::Core.Form.preview', [
                    'form' => $childForm,
                    'mode' => $readOnly,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php echo $form->scripts; ?>

<?php /**PATH /var/www/packages/behin-simple-workflow-g1/src/Views/Core/Form/preview.blade.php ENDPATH**/ ?>