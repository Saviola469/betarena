import React from 'react';
import './Card.css';

export interface CardProps {
  children: React.ReactNode;
  className?: string;
}

const Card: React.FC<CardProps> = ({ children, className }) => (
  <div className={`card ${className || ''}`.trim()}>
    {children}
  </div>
);

export default Card;
