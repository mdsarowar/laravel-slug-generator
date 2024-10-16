<?php
namespace Sarowar\LaravelSlugGenerator;

use Illuminate\Support\Collection;

class LaravelSlug
{
    /**
     * Generate a Unique Slug.
     *
     * @param object $model
     * @param string $title
     * @param string $field
     * @param string $separator
     *
     * @return string
     * @throws \Exception
     */
    private $banglaToEnglish = [
        'অ' => 'a',
        'আ' => 'a',
        'ই' => 'i',
        'ঈ' => 'i',
        'উ' => 'u',
        'ঊ' => 'u',
        'ঋ' => 'r',
        'এ' => 'e',
        'ঐ' => 'oi',
        'ও' => 'o',
        'ঔ' => 'ou',
        'ক' => 'k',
        'খ' => 'kh',
        'গ' => 'g',
        'ঘ' => 'gh',
        'ঙ' => 'ng',
        'চ' => 'ch',
        'ছ' => 'chh',
        'জ' => 'j',
        'ঝ' => 'jh',
        'ঞ' => 'n',
        'ট' => 't',
        'ঠ' => 'th',
        'ড' => 'd',
        'ঢ' => 'dh',
        'ণ' => 'n',
        'ত' => 't',
        'থ' => 'th',
        'দ' => 'd',
        'ধ' => 'dh',
        'ন' => 'n',
        'প' => 'p',
        'ফ' => 'ph',
        'ব' => 'b',
        'ভ' => 'bh',
        'ম' => 'm',
        'য' => 'j',
        'র' => 'r',
        'ল' => 'l',
        'শ' => 'sh',
        'ষ' => 'sh',
        'স' => 's',
        'হ' => 'h',
        'ড়' => 'r',
        'ঢ়' => 'rh',
        'য়' => 'y',
        'ৎ' => 't',
        'ং' => 'ng',
        'ঃ' => 'h',
        'ঁ' => 'n',
        'া' => 'a',
        'ি' => 'i',
        'ী' => 'i',
        'ু' => 'u',
        'ূ' => 'u',
        'ে' => 'e',
        'ৈ' => 'oi',
        'ো' => 'o',
        'ৌ' => 'ou',
        'ৗ' => 'ou',
        'ঊ' => 'u',

    ];

    public function generate($model, $title, $field, $separator = null): string
    {
        $separator = config('sarowar-slug-generator.separator');
        $maxLength = config('sarowar-slug-generator.max_length');

        $title = $this->convertBanglaToEnglish($title);
        // Generate the initial slug
        $slug = $this->createSlug($title, $separator);

        // Limit the length of the slug
        $slug = $this->limitSlugLength($slug, 100);

        // Fetch existing slugs from the database
        $allSlugs = $this->getRelatedSlugs($slug, $model, $field);

        // Return unique slug
        return $this->uniqueSlug($slug, $allSlugs, $field, $separator);
    }


    private function convertBanglaToEnglish($title): string
    {
        // এখানে ম্যাপিং অ্যারে ব্যবহার করা হচ্ছে
        return strtr($title, $this->banglaToEnglish);
    }
    /**
     * Create a slug from the given title.
     *
     * @param string $title
     * @param string $separator
     * @return string
     */
    private function createSlug(string $title, string $separator): string
    {
        // Normalize the title and replace unwanted characters
        $slug = preg_replace('/\s+|[\/\?#+]/', $separator, trim(strtolower($title)));

        // Remove special characters except letters, numbers, and separator
        $slug = preg_replace('![^' . preg_quote($separator) . '\pL\pN]+!u', '', $slug);

        // Replace multiple separators with a single separator
        $slug = preg_replace('![' . preg_quote($separator) . ']+!u', $separator, $slug);

        // Remove trailing separator
        return rtrim($slug, $separator);
    }

    /**
     * Limit the length of the slug.
     *
     * @param string $slug
     * @param int $maxLength
     * @return string
     */
    private function limitSlugLength(string $slug, int $maxLength): string
    {
        return substr($slug, 0, $maxLength);
    }

    /**
     * Get existing slugs related to the new slug.
     *
     * @param string $slug
     * @param object $model
     * @param string $field
     * @return \Illuminate\Support\Collection
     */
    private function getRelatedSlugs(string $slug, $model, string $field): Collection
    {
        return $model::select($field)
            ->where($field, 'like', $slug . '%')
            ->get();
    }

    /**
     * Generate a unique slug by appending numbers if needed.
     *
     * @param string $slug
     * @param \Illuminate\Support\Collection $allSlugs
     * @param string $field
     * @param string $separator
     * @return string
     * @throws \Exception
     */
    private function uniqueSlug(string $slug, Collection $allSlugs, string $field, string $separator): string
    {
//        dd(!$allSlugs->contains($field, $slug));
        // Check if the slug is unique
        if (!$allSlugs->contains($field, $slug)) {
//            dd($allSlugs);
            return $slug; // Slug is unique
        }

//        dd($slug);

        // Append numbers to create a unique slug
        for ($i = 1; $i <= 100; $i++) {
            $newSlug = $slug . $separator . $i;
            if (!$allSlugs->contains($field, $newSlug)) {
                return $newSlug; // Unique slug found
            }
        }

        throw new \Exception('Cannot create a unique slug');
    }
}
