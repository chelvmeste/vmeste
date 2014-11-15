<div class="panel-group" id="side-list-inner">
    <div class="panel panel-default">
        <div class="panel-heading" id="side-list-offers-header">
            <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#side-list-inner" href="#side-list-offers-collapse" aria-expanded="false" aria-controls="side-list-offers-collapse">
                    <?php echo  trans('global.header.help-offers'); ?>
                </a>
            </h4>
        </div>
        <div id="side-list-offers-collapse" class="panel-collapse collapse" aria-labelledby="side-list-offers-header">
            <div class="panel-body offer-panel">

                {{#offers}}
                <ul class="list-group">
                    {{> offerItem}}
                </ul>
                {{/offers}}

            </div>
        </div>
    </div>
    <div class="panel panel-default" id="side-lists-requests">
        <div class="panel-heading" id="side-list-requests-header">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#side-list-inner" href="#side-list-requests-collapse" aria-expanded="true" aria-controls="side-list-requests-collapse">
                    <?php echo  trans('global.header.help-requests'); ?>
                </a>
            </h4>
        </div>
        <div id="side-list-requests-collapse" class="panel-collapse collapse in" aria-labelledby="side-list-requests-header">
            <div class="panel-body offer-panel">

                {{#requests}}
                <ul class="list-group">
                    {{> requestItem}}
                </ul>
                {{/requests}}

            </div>
        </div>
    </div>
</div>