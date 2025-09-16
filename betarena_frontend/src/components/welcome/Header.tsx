import React, { useState, useEffect } from 'react';
import Button from '../ui/Button';
import LoginModal from '../auth/LoginModal';
import RegisterModal from '../auth/RegisterModal';

const Header = () => {
  const [loginOpen, setLoginOpen] = useState(false);
  const [registerOpen, setRegisterOpen] = useState(false);

  useEffect(() => {
    const handler = () => setRegisterOpen(true);
    window.addEventListener('open-register-modal', handler);
    return () => window.removeEventListener('open-register-modal', handler);
  }, []);

  return (
    <header>
      <div className="container">
        <div className="header-content">
          <div className="logo">
            <img src="https://cdn.abacus.ai/images/de3f90ab-d77d-4f33-b453-a7bfe157732a.png" alt="Betarena Logo" style={{ height: '120px' }} />
          </div>
          <div className="user-actions">
            <Button variant="outline" onClick={() => setLoginOpen(true)}>Connexion</Button>
            <Button variant="primary" onClick={() => setRegisterOpen(true)}>Inscription</Button>
          </div>
        </div>
      </div>
      <LoginModal isOpen={loginOpen} onClose={() => setLoginOpen(false)} />
      <RegisterModal isOpen={registerOpen} onClose={() => setRegisterOpen(false)} />
    </header>
  );
};

export default Header;
