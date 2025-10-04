import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import './Sidebar.css';

const Sidebar: React.FC = () => {
  const location = useLocation();

  const menuItems = [
    {
      path: '/dashboard',
      icon: '🏠',
      label: 'Accueil',
      active: location.pathname === '/dashboard'
    },
    {
      path: '/dashboard/bets',
      icon: '🎯',
      label: 'Mes Paris',
      active: location.pathname === '/dashboard/bets'
    },
    {
      path: '/dashboard/create-bet',
      icon: '➕',
      label: 'Créer un Pari',
      active: location.pathname === '/dashboard/create-bet'
    },
    {
      path: '/dashboard/tournaments',
      icon: '🏆',
      label: 'Tournois',
      active: location.pathname === '/dashboard/tournaments'
    },
    {
      path: '/dashboard/clans',
      icon: '👥',
      label: 'Clans',
      active: location.pathname === '/dashboard/clans'
    },
    {
      path: '/dashboard/leaderboard',
      icon: '📊',
      label: 'Classement',
      active: location.pathname === '/dashboard/leaderboard'
    },
    {
      path: '/dashboard/profile',
      icon: '👤',
      label: 'Profil',
      active: location.pathname === '/dashboard/profile'
    },
    {
      path: '/dashboard/wallet',
      icon: '💰',
      label: 'Portefeuille',
      active: location.pathname === '/dashboard/wallet'
    }
  ];

  const handleLogout = () => {
    localStorage.removeItem('user');
    localStorage.removeItem('token');
    window.location.href = '/';
  };

  return (
    <div className="sidebar">
      <div className="sidebar-header">
        <div className="logo">
          <span className="logo-icon">🎮</span>
          <span className="logo-text">BetArena</span>
        </div>
      </div>

      <nav className="sidebar-nav">
        {menuItems.map((item) => (
          <Link
            key={item.path}
            to={item.path}
            className={`nav-item ${item.active ? 'active' : ''}`}
          >
            <span className="nav-icon">{item.icon}</span>
            <span className="nav-label">{item.label}</span>
          </Link>
        ))}
      </nav>

      <div className="sidebar-footer">
        <button className="logout-btn" onClick={handleLogout}>
          <span className="nav-icon">🚪</span>
          <span className="nav-label">Déconnexion</span>
        </button>
      </div>
    </div>
  );
};

export default Sidebar;