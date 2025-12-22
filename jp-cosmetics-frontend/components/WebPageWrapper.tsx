import React from 'react';

interface WebPageWrapperProps {
  children: React.ReactNode;
  className?: string; // Optional: allows you to pass extra classes if needed later
}

const WebPageWrapper: React.FC<WebPageWrapperProps> = ({ children, className = '' }) => {
  return (
    <div className={`px-[5%] ${className}`}>
      {children}
    </div>
  );
};

export default WebPageWrapper;