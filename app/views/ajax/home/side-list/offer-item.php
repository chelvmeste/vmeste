<li class="list-unstyled select-offer" data-offer-id="{{key}}" data-offer-type="offers">
    <address>
        <strong>{{user.first_name}} {{user.last_name}}</strong>, {{user.address}}<br>
        {{#days}}
            {{day_f}}: {{time_start}} - {{time_end}}{{^last}}<br />{{/last}}
        {{/days}}
    </address>
    <hr />
</li>