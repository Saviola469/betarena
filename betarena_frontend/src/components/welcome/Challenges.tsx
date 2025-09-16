import React from 'react';
import '../../App.css';

const handleClick = () => alert('Fonctionnalité en cours de développement!');

const Challenges = () => (
  <section className="challenges">
    <div className="container">
      <h2 className="section-title">Défis en cours</h2>
      <div className="challenges-grid">
        {/* Challenge Card 1 */}
        <div className="challenge-card">
          <div className="challenge-header">
            <div className="game-badge">FIFA 24</div>
            <div className="challenge-amount">25€</div>
          </div>
          <div className="challenge-body">
            <div className="players">
              <div className="player">
                <div className="player-avatar" style={{backgroundColor: '#6c42f5'}}></div>
                <div className="player-name">FifaMaster92</div>
              </div>
              <div className="vs">VS</div>
              <div className="player">
                <div className="player-avatar" style={{backgroundColor: '#ff3860'}}></div>
                <div className="player-name">GoalHunter</div>
              </div>
            </div>
            <p>Match en 1v1 - First to 3 goals</p>
          </div>
          <div className="challenge-footer">
            <div className="challenge-time">Il y a 12 min</div>
            <button className="btn btn-primary" onClick={handleClick}>Relever le défi</button>
          </div>
        </div>
        {/* Challenge Card 2 */}
        <div className="challenge-card">
          <div className="challenge-header">
            <div className="game-badge">Call of Duty</div>
            <div className="challenge-amount">50€</div>
          </div>
          <div className="challenge-body">
            <div className="players">
              <div className="player">
                <div className="player-avatar" style={{backgroundColor: '#23d160'}}></div>
                <div className="player-name">SniperPro</div>
              </div>
              <div className="vs">VS</div>
              <div className="player">
                <div className="player-avatar" style={{backgroundColor: '#ff3860'}}></div>
                <div className="player-name">En attente...</div>
              </div>
            </div>
            <p>1v1 Search & Destroy - Best of 5</p>
          </div>
          <div className="challenge-footer">
            <div className="challenge-time">Il y a 23 min</div>
            <button className="btn btn-primary" onClick={handleClick}>Relever le défi</button>
          </div>
        </div>
        {/* Challenge Card 3 */}
        <div className="challenge-card">
          <div className="challenge-header">
            <div className="game-badge">Fortnite</div>
            <div className="challenge-amount">15€</div>
          </div>
          <div className="challenge-body">
            <div className="players">
              <div className="player">
                <div className="player-avatar" style={{backgroundColor: '#6c42f5'}}></div>
                <div className="player-name">BuildMaster</div>
              </div>
              <div className="vs">VS</div>
              <div className="player">
                <div className="player-avatar" style={{backgroundColor: '#ff3860'}}></div>
                <div className="player-name">NoobSlayer</div>
              </div>
            </div>
            <p>Battle Royale - Premier à 5 éliminations</p>
          </div>
          <div className="challenge-footer">
            <div className="challenge-time">Il y a 5 min</div>
            <button className="btn btn-primary" onClick={handleClick}>Voir le match</button>
          </div>
        </div>
      </div>
    </div>
  </section>
);

export default Challenges;
