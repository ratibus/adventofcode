<?php

// Solved in 14 minutes

$ingredientsLists = [];
$completeAllergens = [];
$completeIngredients = [];
foreach (file(__DIR__.'/'.$argv[1], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
    list($ingredients, $allergens) = explode(' (contains ', substr($line, 0, -1));
    $ingredients = explode(' ', $ingredients);
    $allergens = explode(', ', $allergens);

    $ingredients = array_combine($ingredients, $ingredients);
    $allergens = array_combine($allergens, $allergens);
    $completeAllergens = array_merge($completeAllergens, $allergens);
    $completeIngredients = array_merge($completeIngredients, $ingredients);

    $ingredientsLists[] = ['ingredients' => $ingredients, 'allergens' => $allergens];
}

$possibleIngredientsWithAllergens = [];
foreach ($completeAllergens as $allergen) {
    $possibleIngredients = $completeIngredients;
    foreach ($ingredientsLists as $ingredientsList) {
        if (!isset($ingredientsList['allergens'][$allergen])) {
            continue;
        }
        $possibleIngredients = array_intersect($possibleIngredients, $ingredientsList['ingredients']);
    }
    $possibleIngredientsWithAllergens = array_merge($possibleIngredientsWithAllergens, $possibleIngredients);
}

$associationsFound = [];
$allergensToFind = $completeAllergens;
while (count($allergensToFind)) {
    foreach ($allergensToFind as $allergen) {
        $possibleIngredients = $possibleIngredientsWithAllergens;
        foreach ($ingredientsLists as $ingredientsList) {
            if (!isset($ingredientsList['allergens'][$allergen])) {
                continue;
            }
            $possibleIngredients = array_intersect($possibleIngredients, $ingredientsList['ingredients']);
        }

        foreach ($possibleIngredients as $possibleIngredient) {
            foreach ($associationsFound as $assocAllergen => $assocIngredient) {
                unset($possibleIngredients[$assocIngredient]);
            }
        }

        if (count($possibleIngredients) === 1) {
            $associationsFound[$allergen] = array_values($possibleIngredients)[0];
            unset($allergensToFind[$allergen]);
        }
    }
}

ksort($associationsFound);

var_dump(implode(',', $associationsFound));
