<?php

// Solved in 33 minutes

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

$possibleIngredientsWithNoAllergens = array_diff($completeIngredients, $possibleIngredientsWithAllergens);

$nbPossibleIngredientsListsWithNoAllergens = 0;
foreach ($ingredientsLists as $ingredientsList) {
    foreach ($possibleIngredientsWithNoAllergens as $possibleIngredientWithNoAllergens) {
        if (isset($ingredientsList['ingredients'][$possibleIngredientWithNoAllergens])) {
            $nbPossibleIngredientsListsWithNoAllergens++;
        }
    }
}
var_dump($nbPossibleIngredientsListsWithNoAllergens);

