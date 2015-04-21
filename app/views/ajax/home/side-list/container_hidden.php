<div style="display: none;">
    {{#offers}}
        <ul class="list-group">
            {{> offerItem}}
        </ul>
    {{/offers}}
    {{#requests}}
        <ul class="list-group">
            {{> requestItem}}
        </ul>
    {{/requests}}
</div>
