<?php
declare(strict_types=1);


namespace BobbyAHines\JeffersonParishCodePdf;


class Charter
{
    public string $preamble;
    public array $chapters;

    public function __construct(string $documentText)
    {
        $charterText = $this->charterTextOnly($documentText);
        $this->preamble = $this->preambleText($charterText);
        $this->chapters = $this->chapters($charterText);
    }

    private function titleAllPreambleArticles(string $text): string
    {
        $regExPattern = '/(ARTICLE\s\d+\.\d*\.?\s)/';
        $levelThreeHeader = '### ';

        return preg_replace($regExPattern, $levelThreeHeader . '${1}', $text);
    }

    private function titleAllPreambleSections(string $text): string
    {
        $regExPattern = '/(Section\s\d+\.\d*\.?\s-\s)/';
        $levelFiveHeader = '##### ';

        return preg_replace($regExPattern, $levelFiveHeader . '${1}', $text);
    }

    private function titleAllChapters(string $text): string
    {
        $regExPattern = '/(Chapter \d{1,4}\.?\d* - )/';
        $levelTwoHeader = '## ';

        return preg_replace($regExPattern, $levelTwoHeader . '${1}', $text);
    }

    private function titleAllChapterArticles(string $text): string
    {
        $regExPattern = '/(ARTICLE\s[I,L,V,X]*\.\s-\s)/';
        $levelThreeHeader = '### ';

        return preg_replace($regExPattern, $levelThreeHeader . '${1}', $text);
    }

    private function titleAllChapterDivisions(string $text): string
    {
        $regExPattern = '/(DIVISION\s\d+\.\d?\.?)/';
        $levelFourHeader = '#### ';

        return preg_replace($regExPattern, $levelFourHeader . '${1}', $text);
    }

    private function titleAllChapterSections(string $text): string
    {
        $levelFiveHeader = '##### ';
        $regExPattern = '/((Sec\.\s\d+\.\d*-\d*\.)(\s-\s)(.+?\.))|((Sec\.\s\d+-\d*\.)(\s-\s)(.+?\.))/';
        $replacementOne = preg_replace($regExPattern, $levelFiveHeader . '${1}' . '  ' . PHP_EOL, $text);;

        $regExPatternTwo = '/((Sec\.\s\d+-\d+\.\d+\.)(\s-\s)(.+?\.))/';

        return preg_replace($regExPatternTwo, $levelFiveHeader . '${1}' . '  ' . PHP_EOL, $replacementOne);
    }

    private function charterTextOnly(string $documentText): string
    {
        $regExPattern = '/((THE\sCHARTER)(\nPreamble)(\nPREAMBLE))/';
        $searchPattern = preg_match($regExPattern, $documentText, $matches);
        $explodeOnFind = explode($matches[0], $documentText);
        $charterTextWithNoTitle = $explodeOnFind[1];
        $charterText = '# THE CHARTER  ' . PHP_EOL . PHP_EOL . '## PREAMBLE  ' . PHP_EOL . PHP_EOL . $charterTextWithNoTitle;
        unset($regExPattern, $searchPattern, $explodeOnFind, $charterTextWithNoTitle);

        $addPreambleArticleTitles = $this->titleAllPreambleArticles($charterText);
        unset($charterText);
        $addPreambleSectionTitles = $this->titleAllPreambleSections($addPreambleArticleTitles);
        unset($addPreambleArticleTitles);
        $addChapterTitles = $this->titleAllChapters($addPreambleSectionTitles);
        unset($addPreambleSectionTitles);
        $addChapterArticleTitles = $this->titleAllChapterArticles($addChapterTitles);
        unset($addChapterTitles);
        $addChapterDivisionTitles = $this->titleAllChapterDivisions($addChapterArticleTitles);
        unset($addChapterArticleTitles);
        $addChapterSectionTitles = $this->titleAllChapterSections($addChapterDivisionTitles);
        unset($addChapterDivisionTitles);

        return $addChapterSectionTitles;
    }

    private function preambleText(string $text): string
    {
        $regExPattern = '/(## Chapter \d{1,4}\.?\d* - )/';
        $searchPattern = preg_match($regExPattern, $text, $matches);
        $explodeOnFind = explode($matches[0], $text);

        return $explodeOnFind[0];
    }

    private function chapters(string $text): array
    {
        $explodeOnChapterTitles = explode('## Chapter ', $text);
        unset($explodeOnChapterTitles[0]);

        $chapters = [];
        foreach ($explodeOnChapterTitles as $chapter) {
            $chapterNumberRegEx = '/((\d*)(\.\d*)?)\s-\s/';
            $chapterNumberSearch = preg_match($chapterNumberRegEx, $chapter, $chapterNumberSearchMatches);
            $chapterNumberSearchMatch = (float)$chapterNumberSearchMatches[1];
            $addZeroIfLessThanTen = $chapterNumberSearchMatch < 10 ? '0' . $chapterNumberSearchMatches[1] : (string)$chapterNumberSearchMatches[1];
            $chapterMatch = strpos($addZeroIfLessThanTen, '.') !== false ? $addZeroIfLessThanTen : $addZeroIfLessThanTen . '.0';
            $chapters[] = [
                'number' => $chapterMatch,
                'text' => '## Chapter ' . $chapter,
            ];
            unset($chapterNumberSearch, $chapterNumberSearchMatches);
        }
        unset($explodeOnChapterTitles);

        return $chapters;
    }
}