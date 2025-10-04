import React from 'react';
import Header from './Header';
import Hero from './Hero';
import Features from './Features';
import Challenges from './Challenges';
import CTA from './CTA';
import Footer from './Footer';

const WelcomePage: React.FC = () => {
  return (
    <>
      <Header />
      <Hero />
      <Features />
      <Challenges />
      <CTA />
      <Footer />
    </>
  );
};

export default WelcomePage;