import React, { useState } from 'react';
import Modal from '../ui/Modal';
import Button from '../ui/Button';

interface RegisterModalProps {
  isOpen: boolean;
  onClose: () => void;
  onRegisterSuccess?: (user: any) => void;
}

const RegisterModal: React.FC<RegisterModalProps> = ({ isOpen, onClose, onRegisterSuccess }) => {
  const [name, setName] = useState('');
  const [pseudo, setPseudo] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirm, setPasswordConfirm] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      const response = await fetch('/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name, pseudo, email, password, password_confirmation: passwordConfirm }),
      });
      const data = await response.json();
      if (!response.ok) {
        setError(data.message || 'Erreur d\'inscription');
      } else {
        if (onRegisterSuccess) onRegisterSuccess(data);
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
        <h2>Inscription</h2>
        <div className="form-group">
          <label htmlFor="name">Nom</label>
          <input id="name" type="text" placeholder="Nom" value={name} onChange={e => setName(e.target.value)} required />
        </div>
        <div className="form-group">
          <label htmlFor="pseudo">Pseudo</label>
          <input id="pseudo" type="text" placeholder="Pseudo" value={pseudo} onChange={e => setPseudo(e.target.value)} required />
        </div>
        <div className="form-group">
          <label htmlFor="email">Email</label>
          <input id="email" type="email" placeholder="Email" value={email} onChange={e => setEmail(e.target.value)} required />
        </div>
        <div className="form-group">
          <label htmlFor="password">Mot de passe</label>
          <input id="password" type="password" placeholder="Mot de passe" value={password} onChange={e => setPassword(e.target.value)} required />
        </div>
        <div className="form-group">
          <label htmlFor="passwordConfirm">Confirmer le mot de passe</label>
          <input id="passwordConfirm" type="password" placeholder="Confirmer le mot de passe" value={passwordConfirm} onChange={e => setPasswordConfirm(e.target.value)} required />
        </div>
        {error && <div className="error-message">{error}</div>}
        <Button type="submit" variant="primary" disabled={loading}>
          {loading ? 'Inscription...' : "S'inscrire"}
        </Button>
      </form>
    </Modal>
  );
};

export default RegisterModal;
