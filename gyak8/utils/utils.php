<?php
    function load_data(string $path): array {
        if (!file_exists($path)) return [];

        $raw = file_get_contents($path);

        // A raw stringet dekódolni kell asszociatív tömbbé
        return [];
    }

    function save_data(string $path, array $user): void {
        $users = load_data($path);
        $users[] = $user;

        // Ezt be kéne íratni a $path által meghatározott fájlba
        json_encode($users);
    }