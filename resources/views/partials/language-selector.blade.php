<select id="languageSelect"  onchange="changeLanguage(this)">
    @foreach (config('app.supported_locales') as $locale => $language)
        <option value="{{ $locale }}" @if ($locale === app()->getLocale()) selected @endif>
            {{ $language }}
        </option>
    @endforeach
</select>

<script>
    function changeLanguage(select) {
        var locale = select.value;
        window.location.href = "{{ route('change.language') }}" + "?locale=" + locale;
    }
</script>