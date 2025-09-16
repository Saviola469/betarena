import React, { useState } from 'react';
import Modal from '../ui/Modal';
import Button from '../ui/Button';

interface LoginModalProps {
  isOpen: boolean;
  onClose: () => void;
  onLoginSuccess?: (user: any) => void;
}

const LoginModal: React.FC<LoginModalProps> = ({ isOpen, onClose, onLoginSuccess }) => {
  const [identifier, setIdentifier] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ identifier, password }),
      });
      const data = await response.json();
      if (!response.ok) {
        setError(data.message || 'Erreur de connexion');
      } else {
        if (onLoginSuccess) onLoginSuccess(data);
        onClose();
      }
    } catch (err) {
      setError('Erreur réseau');
    } finally {
      setLoading(false);
    }
  };

  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <form className="login-modal-form" onSubmit={handleSubmit}>
        <h2>Connexion</h2>
        <div className="form-group">
          <label htmlFor="identifier">Identifiant</label>
          <input
            id="identifier"
            type="text"
            placeholder="Email ou Pseudo"
            value={identifier}
            onChange={e => setIdentifier(e.target.value)}
            required
            autoFocus
          />
        </div>
        <div className="form-group">
          <label htmlFor="password">Mot de passe</label>
          <input
            id="password"
            type="password"
            placeholder="Mot de passe"
            value={password}
            onChange={e => setPassword(e.target.value)}
            required
          />
          <a href="#" className="forgot-password-link" style={{marginTop: '4px', fontSize: '0.95rem', color: '#2563eb', textDecoration: 'underline', alignSelf: 'flex-start'}}>Mot de passe oublié ?</a>
        </div>
        {error && <div className="error-message">{error}</div>}
        <Button type="submit" variant="primary" disabled={loading}>
          {loading ? 'Connexion...' : 'Se connecter'}
        </Button>
        <div style={{marginTop: '10px', textAlign: 'center'}}>
          <span style={{color: '#19213a'}}>Vous n'avez pas de compte ?</span>
          <Button variant="outline" style={{marginLeft: '8px'}} onClick={() => {
            onClose();
            window.dispatchEvent(new CustomEvent('open-register-modal'));
          }}>
            S'inscrire
          </Button>
        </div>
      </form>
    </Modal>
  );
};

export default LoginModal;
