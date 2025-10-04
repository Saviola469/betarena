

import React, { useState } from 'react';
import { Routes, Route } from 'react-router-dom';
import WelcomePage from './components/welcome/WelcomePage';
import Dashboard from './components/dashboard/Dashboard';
import LoginModal from './components/auth/LoginModal';
import RegisterModal from './components/auth/RegisterModal';
import './App.css';

function App() {
  const [isLoginModalOpen, setIsLoginModalOpen] = useState(false);
  const [isRegisterModalOpen, setIsRegisterModalOpen] = useState(false);

  const handleLoginSuccess = (data: any) => {
    localStorage.setItem('user', JSON.stringify(data.user));
    localStorage.setItem('token', data.token);
    setIsLoginModalOpen(false);
    window.location.href = '/dashboard';
  };

  const handleRegisterSuccess = (data: any) => {
    localStorage.setItem('user', JSON.stringify(data.user));
    localStorage.setItem('token', data.token);
    setIsRegisterModalOpen(false);
    window.location.href = '/dashboard';
  };

  // Exposer les fonctions globalement pour les événements personnalisés
  React.useEffect(() => {
    const handleOpenLogin = () => setIsLoginModalOpen(true);
    const handleOpenRegister = () => setIsRegisterModalOpen(true);

    window.addEventListener('open-login-modal', handleOpenLogin);
    window.addEventListener('open-register-modal', handleOpenRegister);

    return () => {
      window.removeEventListener('open-login-modal', handleOpenLogin);
      window.removeEventListener('open-register-modal', handleOpenRegister);
    };
  }, []);

  return (
    <>
      <Routes>
        <Route path="/" element={<WelcomePage />} />
        <Route path="/dashboard" element={<Dashboard />} />
      </Routes>
      
      <LoginModal
        isOpen={isLoginModalOpen}
        onClose={() => setIsLoginModalOpen(false)}
        onLoginSuccess={handleLoginSuccess}
      />

      <RegisterModal
        isOpen={isRegisterModalOpen}
        onClose={() => setIsRegisterModalOpen(false)}
        onRegisterSuccess={handleRegisterSuccess}
      />
    </>
  );
}

export default App;
