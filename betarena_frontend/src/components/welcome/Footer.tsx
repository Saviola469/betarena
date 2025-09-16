import React from 'react';
import '../../App.css';

const Footer = () => (
  <footer>
    <div className="container">
      <div className="footer-content">
        <div className="footer-column">
          <h3>Betarena</h3>
          <ul>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Comment ça marche</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Carrières</a></li>
          </ul>
        </div>
        <div className="footer-column">
          <h3>Légal</h3>
          <ul>
            <li><a href="#">Conditions d'utilisation</a></li>
            <li><a href="#">Politique de confidentialité</a></li>
            <li><a href="#">Politique de cookies</a></li>
            <li><a href="#">Mentions légales</a></li>
          </ul>
        </div>
        <div className="footer-column">
          <h3>Support</h3>
          <ul>
            <li><a href="#">Centre d'aide</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">État du service</a></li>
            <li><a href="#">Signaler un problème</a></li>
          </ul>
        </div>
        <div className="footer-column">
          <h3>Suivez-nous</h3>
          <ul>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Discord</a></li>
            <li><a href="#">Instagram</a></li>
            <li><a href="#">Twitch</a></li>
          </ul>
        </div>
      </div>
      <div className="copyright">
        &copy; 2025 Betarena - Tous droits réservés
      </div>
    </div>
  </footer>
);

export default Footer;
