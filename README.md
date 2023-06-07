# Plugin de maillage interne

Pour faire fonctionner ce plugin : 
1) Installer le plugin dans un dossier /wp-plugins WordPress
2) Activer le plugin
3) Sur la page d'administration, ajouter sa clef API Babbar
4) Profiter !
5) Pour faker le résultat, modifier la valeur de l'url dans la page d'administration "Maillage interne"

## Comment améliorer ? 
1) Améliorer le rendu en utilisant le reste de l'objet JSON. On utilise actuellement seulement les champs 'title' et 'url'. On pourrait ajouter d'autres stats, par ex. un nombre d'étoiles selon la similitude avec la page actuelle.
2) Mettre les liens sous forme de carte, avec une image (si on peut en avoir une)
3) Améliorer le CSS de l'admin, mettre les input en colonne et utiliser les boutons Wordpress (classes wp-button, voir la doc)
4) Améliorer la gestion des erreurs
5) Mettre en place un algorithme de bandits manchots (si on peut)
