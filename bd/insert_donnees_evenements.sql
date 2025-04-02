-- Insertion des données de test pour les événements
INSERT INTO evenement (
    titre, 
    description, 
    date_evenement, 
    prix, 
    max_participants, 
    nb_inscrits, 
    chemin_image
) VALUES 
(
    'Soirée Bowling',
    'Venez participer à notre soirée bowling ! Au programme : compétition amicale, pizza et bonne ambiance garantie.',
    '2024-04-15 19:00:00',
    5.00,
    30,
    0,
    'assets/images/events/bowling.png'
),
(
    'Tournoi Poker',
    'Grand tournoi de poker organisé en 3 table de 6, lots à gagner pour les meilleures !',
    '2024-04-20 14:00:00',
    0.00,
    18,
    0,
    'assets/images/events/poker.png'
),
(
    'Patie de mini-golf',
    'Une soirée complète de mini-golf !',
    '2024-05-03 20:00:00',
    8.00,
    25,
    0,
    'assets/images/events/golf.png'
);
