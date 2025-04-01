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
    'assets/images/events/bowling.jpg'
),
(
    'Tournoi CS:GO',
    'Grand tournoi CS:GO organisé dans les salles info. 5vs5, lots à gagner pour les meilleures équipes !',
    '2024-04-20 14:00:00',
    0.00,
    40,
    0,
    'assets/images/events/csgo.jpg'
),
(
    'Soirée Jeux de Société',
    'Une soirée détente autour de jeux de société. Snacks et boissons offerts !',
    '2024-04-25 18:30:00',
    2.00,
    25,
    0,
    'assets/images/events/board-games.jpg'
),
(
    'LAN Party',
    'Une nuit complète de gaming ! Amenez vos PC, on s''occupe du reste.',
    '2024-05-03 20:00:00',
    8.00,
    50,
    0,
    'assets/images/events/lan-party.jpg'
),
(
    'Barbecue de fin d''année',
    'Le traditionnel barbecue pour célébrer la fin de l''année scolaire ! Venez nombreux !',
    '2024-06-15 12:00:00',
    10.00,
    100,
    0,
    'assets/images/events/bbq.jpg'
);
