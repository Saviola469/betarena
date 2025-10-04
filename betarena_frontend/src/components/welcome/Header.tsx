import React from 'react';
import Button from '../ui/Button';

const Header = () => {
  const handleLoginClick = () => {
    window.dispatchEvent(new CustomEvent('open-login-modal'));
  };

  const handleRegisterClick = () => {
    window.dispatchEvent(new CustomEvent('open-register-modal'));
  };

  return (
    <header style={{ background: 'linear-gradient(to bottom, #F0F4FF, #E0F7FA)', boxShadow: 'none', borderBottom: 'none' }}>
      <div className="container">
        <div className="header-content">
          <div className="logo">
            <img src="https://cdn.abacus.ai/images/de3f90ab-d77d-4f33-b453-a7bfe157732a.png" alt="Betarena Logo" style={{ height: '120px' }} />
          </div>
          <div className="user-actions">
            <Button variant="outline" onClick={handleLoginClick}>Connexion</Button>
            <Button variant="primary" onClick={handleRegisterClick}>Inscription</Button>
          </div>
        </div>
      </div>
    </header>
  );
};

export default Header;
