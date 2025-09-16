import React from 'react';
import '../../App.css';

const CTA = () => (
  <section className="cta">
    <div className="container">
      <h2>Prêt à relever le défi ?</h2>
      <p>Rejoignez des milliers de gamers qui monétisent leurs skills et transforment chaque match en arène compétitive.</p>
      <button className="btn btn-primary" onClick={() => window.dispatchEvent(new CustomEvent('open-register-modal'))}>Créer un compte gratuit</button>
    </div>
  </section>
);

export default CTA;
