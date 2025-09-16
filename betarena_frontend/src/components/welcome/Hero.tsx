import React from 'react';
import '../../App.css';

const Hero = () => (
  <section className="hero">
    <div className="container">
      <h1>L'arène des paris entre gamers</h1>
      <p>Affrontez d'autres joueurs, déposez votre mise, et remportez le pot grâce à notre système sécurisé d'escrow.</p>
      <button className="btn btn-primary" onClick={() => window.dispatchEvent(new CustomEvent('open-login-modal'))}>Créer un défi</button>
    </div>
  </section>
);

export default Hero;
