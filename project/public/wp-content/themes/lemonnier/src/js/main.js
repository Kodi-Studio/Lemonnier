// Import des modules ou des fichiers nécessaires
// import { someFunction } from './utils';
// import '../scss/main.scss';

// Code JavaScript principal
// document.addEventListener('DOMContentLoaded', function() {
//     // Votre code JavaScript ici
//     console.log('Le DOM est prêt');
//     someFunction(); // Appel d'une fonction définie dans un autre fichier
// });

import "../scss/main.scss";

import { Header } from "./components/header.component";

const test = new Header();

test.init();
