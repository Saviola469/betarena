import React from 'react';
import Sidebar from './Sidebar';
import './DashboardLayout.css';

interface DashboardLayoutProps {
  children: React.ReactNode;
}

const DashboardLayout: React.FC<DashboardLayoutProps> = ({ children }) => {
  const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')!) : null;

  return (
    <div className="dashboard-layout">
      <Sidebar />
      
      <div className="main-content">
        <header className="dashboard-header">
          <div className="header-content">
            <h1 className="page-title">Dashboard</h1>
            <div className="user-info">
              {user && (
                <>
                  <div className="user-details">
                    <span className="user-name">{user.name}</span>
                    <span className="user-role">{user.role || 'Player'}</span>
                  </div>
                  <div className="user-avatar">
                    {user.name?.charAt(0)?.toUpperCase() || '?'}
                  </div>
                </>
              )}
            </div>
          </div>
        </header>

        <main className="dashboard-main">
          {children}
        </main>
      </div>
    </div>
  );
};

export default DashboardLayout;