<?php

namespace App\Support;

trait HasTranslatedFields
{
    /**
     * Return the value of $field for the current app locale,
     * falling back to the English column when the translation
     * hasn't been filled in yet (or the locale isn't en/ar).
     */
    public function trans(string $field): ?string
    {
        $locale = app()->getLocale();
        $localized = $this->{"{$field}_{$locale}"} ?? null;

        if (filled($localized)) {
            return $localized;
        }

        return $this->{"{$field}_en"} ?? null;
    }

    /**
     * Same as trans(), but splits on newlines into an array —
     * useful for "included" / bullet-list style textareas.
     */
    public function transLines(string $field): array
    {
        $value = $this->trans($field);

        if (blank($value)) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
