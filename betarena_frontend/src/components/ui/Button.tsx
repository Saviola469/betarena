import React from 'react';
import './Button.css';

export interface ButtonProps {
  variant?: 'primary' | 'outline';
  children: React.ReactNode;
  onClick?: () => void;
  type?: 'button' | 'submit' | 'reset';
  className?: string;
  disabled?: boolean;
  style?: React.CSSProperties;
}

const Button: React.FC<ButtonProps> = ({ variant = 'primary', children, onClick, type = 'button', className, disabled, style }) => {
  return (
    <button
      type={type}
      className={`btn btn-${variant} ${className || ''}`.trim()}
      onClick={onClick}
      disabled={disabled}
      style={style}
    >
      {children}
    </button>
  );
};

export default Button;
