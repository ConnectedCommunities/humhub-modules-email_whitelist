<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Email</strong> rejected
        </div>
        <div class="panel-body">

            <strong><?php echo CHtml::encode($message); ?></strong>

            <br />
            <hr>
            <a href="javascript:history.back();" class="btn btn-primary  pull-right"><?php echo Yii::t('base', 'Back'); ?></a>
        </div>
    </div>
</div>