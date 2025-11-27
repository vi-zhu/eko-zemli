<?php
function truncateTextWithoutSpaces($text, $maxChars = 180) {
    // Удаляем все пробелы из текста
    $textWithoutSpaces = preg_replace('/\s+/', '', $text);

    // Если текст уже короче или равен лимиту, возвращаем как есть
    if (mb_strlen($textWithoutSpaces) <= $maxChars) {
        return $text;
    }

    // Обрезаем текст с помощью TruncateText (он считает с пробелами)
    // Увеличиваем лимит, так как пробелы будут удалены
    $currentLength = 0;
    $result = '';

    // Проходим по словам и добавляем пока не достигнем лимита
    $words = preg_split('/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        $wordWithoutSpaces = preg_replace('/\s+/', '', $word);
        $wordLength = mb_strlen($wordWithoutSpaces);

        if ($currentLength + $wordLength <= $maxChars) {
            $result .= $word;
            $currentLength += $wordLength;
        } else {
            // Если слово слишком длинное, обрезаем его
            $remainingChars = $maxChars - $currentLength;
            if ($remainingChars > 0) {
                // Обрезаем слово до оставшихся символов
                $trimmedWord = mb_substr($word, 0, $remainingChars);
                $result .= $trimmedWord.'...';
            }
            break;
        }
    }

    return $result;
}
