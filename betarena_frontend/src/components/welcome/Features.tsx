import React from 'react';
import '../../App.css';

const Features = () => (
  <section className="features">
    <div className="container">
      <h2 className="section-title">Comment ça marche</h2>
      <div className="features-grid">
        <div className="feature-card">
          <div className="feature-icon">1</div>
          <h3>Créez votre profil</h3>
          <p>Configurez votre profil avec vos jeux préférés, votre pseudo et vos statistiques de jeu.</p>
        </div>
        <div className="feature-card">
          <div className="feature-icon">2</div>
          <h3>Lancez un défi</h3>
          <p>Choisissez le jeu, le mode, le montant et lancez un défi public ou à un ami.</p>
        </div>
        <div className="feature-card">
          <div className="feature-icon">3</div>
          <h3>Jouez et gagnez</h3>
          <p>Affrontez votre adversaire, uploader la preuve de victoire et recevez vos gains.</p>
        </div>
      </div>
    </div>
  </section>
);

export default Features;
