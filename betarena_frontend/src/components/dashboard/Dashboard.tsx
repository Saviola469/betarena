import React from 'react';
import DashboardLayout from './DashboardLayout';
import Button from '../ui/Button';
import Card from '../ui/Card';

const Dashboard: React.FC = () => {
  const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')!) : null;

  return (
    <DashboardLayout>
      <div className="dashboard-home">
        <div className="welcome-section">
          <h2 style={{ color: '#111827', marginBottom: '8px' }}>Bienvenue {user?.name} ! 🎮</h2>
          <p style={{ color: '#4B5563' }}>Voici votre tableau de bord personnel. Gérez vos paris, tournois et suivez vos performances.</p>
        </div>

        <div className="stats-grid" style={{ 
          display: 'grid', 
          gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))', 
          gap: '20px', 
          marginTop: '24px' 
        }}>
          <Card>
            <h3 style={{ margin: '0 0 8px 0', color: '#111827' }}>Paris Actifs</h3>
            <p style={{ fontSize: '24px', fontWeight: 'bold', color: '#3B82F6', margin: 0 }}>0</p>
          </Card>

          <Card>
            <h3 style={{ margin: '0 0 8px 0', color: '#111827' }}>Victoires</h3>
            <p style={{ fontSize: '24px', fontWeight: 'bold', color: '#22c55e', margin: 0 }}>0</p>
          </Card>

          <Card>
            <h3 style={{ margin: '0 0 8px 0', color: '#111827' }}>Solde</h3>
            <p style={{ fontSize: '24px', fontWeight: 'bold', color: '#f59e0b', margin: 0 }}>0€</p>
          </Card>

          <Card>
            <h3 style={{ margin: '0 0 8px 0', color: '#111827' }}>Classement</h3>
            <p style={{ fontSize: '24px', fontWeight: 'bold', color: '#8b5cf6', margin: 0 }}>#-</p>
          </Card>
        </div>

        <Card style={{ marginTop: '32px' }}>
          <h3 style={{ margin: '0 0 16px 0', color: '#111827' }}>Actions Rapides</h3>
          <div style={{ display: 'flex', gap: '12px', flexWrap: 'wrap' }}>
            <Button variant="primary">
              Créer un Pari
            </Button>
            <Button variant="primary" style={{ background: '#6366f1' }}>
              Rejoindre un Tournoi
            </Button>
            <Button variant="primary" style={{ background: '#22c55e' }}>
              Voir le Classement
            </Button>
          </div>
        </Card>
      </div>
    </DashboardLayout>
  );
};

export default Dashboard;