@if(isset($scriptComposer) && !empty($scriptComposer))
<script type="text/javascript">
    @foreach($scriptComposer as $key=>$value)
        var {{ $key }} = {{ $value }};
    @endforeach
</script>
@endif