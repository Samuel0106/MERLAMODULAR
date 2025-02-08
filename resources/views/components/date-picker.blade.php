<div>
    <input
        x-data
        x-ref="input"
        x-on:change="$dispatch('input', $el.value)"
        x-init="new Pikaday({ field: $refs.input, 'format': 'MM/DD/YYYY', firstDay: 1, minDate: new Date(), });"
        type="text"
        {{ $attributes }}
    >
</div>