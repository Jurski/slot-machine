<?php

$rows = 3;
$columns = 3;

$possibleBets = [10, 5, 80, 40, 20];

$gameElements = ["A", "A", "A", "A", "A", "B", "B", "B", "B", "C", "C", "C", "D", "D", "7"];

$board = [];

$winningPositions = [
    [[0, 0], [0, 1], [0, 2]],
    [[1, 0], [1, 1], [1, 2]],
    [[2, 0], [2, 1], [2, 2]],
    [[0, 0], [1, 0], [2, 0]],
    [[0, 1], [1, 1], [2, 1]],
    [[0, 2], [1, 2], [2, 2]],
    [[0, 0], [1, 1], [2, 2]],
    [[0, 2], [1, 1], [2, 0]]
];

$elementsRarity = array_count_values($gameElements);
$elementsMultipliers = [];

$minimumOccurrence = min($elementsRarity);

foreach ($elementsRarity as $element => $count) {
    $elementsMultipliers[$element] = ($minimumOccurrence / $count) * 10;
}

$userBalance = (int)readline("Enter your amount of coins:");

while ($userBalance >= min($possibleBets)) {
    $userBet = readline("Enter your bet amount (or 0 to exit):");

    if ($userBet == 0) break;

    if (!in_array($userBet, $possibleBets)) {
        echo "Please enter a valid bet - ";
        foreach ($possibleBets as $bet) {
            echo "$bet points ";
        }
        break;
    }

    if ($userBet > $userBalance) {
        echo "Not enough coins!";
        break;
    }

    for ($row = 0; $row < $rows; $row++) {
        for ($column = 0; $column < $columns; $column++) {
            $board[$row][$column] = $gameElements[array_rand($gameElements)];
        }
    }

    foreach ($board as $row) {
        foreach ($row as $element) {
            echo $element;
        }
        echo PHP_EOL;
    }

    $winTotal = 0;

    foreach ($winningPositions as $position) {
        [$first, $second, $third] = $position;
        [$firstRow, $firstCol] = $first;
        [$secondRow, $secondCol] = $second;
        [$thirdRow, $thirdCol] = $third;

        if ($board[$firstRow][$firstCol] == $board[$secondRow][$secondCol] &&
            $board[$secondRow][$secondCol] == $board[$thirdRow][$thirdCol]
        ) {
            $winningElement = $board[$firstRow][$firstCol];

            $minimumBet = min($possibleBets);
            $betMultiplier = $userBet / $minimumBet;

            $elementMultiplier = $elementsMultipliers[$winningElement];

            $win = $rows * $elementMultiplier * $betMultiplier;
            $winTotal += $win;

            echo "Winning combo! - you get $win credits" . PHP_EOL;
        }

    }

    $userBalance = $userBalance - $userBet + $winTotal;
    echo "Your current balance - $userBalance credits" . PHP_EOL;
}