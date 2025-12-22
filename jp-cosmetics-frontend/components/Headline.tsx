import React from 'react';

interface HeadlineProps {
  mainText: string;
  subText?: string;
  className?: string;
}

const Headline: React.FC<HeadlineProps> = ({ mainText, subText, className = '' }) => {
  return (
    <div className={`text-center space-y-2 scroll-fade-up ${className}`}>
      <h1 className="text-4xl font-semibold text-[#ec6b81] capitalize">
        {mainText}
      </h1>
      {subText && (
        <h2 className="text-gray-600 tracking-wider italic">
          {subText}
        </h2>
      )}
    </div>
  );
};

export default Headline;