import React, { useState, useEffect, useRef, Suspense, lazy } from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useNavigate } from 'react-router-dom';
import './App.css';

// Skeleton Loading Component
const SkeletonLoader = () => (
  <div className="skeleton-container">
    <div className="skeleton-header"></div>
    <div className="skeleton-content">
      <div className="skeleton-card"></div>
      <div className="skeleton-card"></div>
      <div className="skeleton-card"></div>
    </div>
  </div>
);

// Lazy load pages - create these in src/pages/
const HomePage = lazy(() => import('./pages/HomePage'));
const MissionsPage = lazy(() => import('./pages/MissionsPage'));
const LaunchesPage = lazy(() => import('./pages/LaunchesPage'));
const SatellitesPage = lazy(() => import('./pages/SatellitesPage'));
const BlogPage = lazy(() => import('./pages/BlogPage'));
const GalleryPage = lazy(() => import('./pages/GalleryPage'));
const AboutPage = lazy(() => import('./pages/AboutPage'));

// Main Navigation Component
const Navigation = () => {
  const [isSearchActive, setIsSearchActive] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [showSuggestions, setShowSuggestions] = useState(false);
  const [isMobileMenuActive, setIsMobileMenuActive] = useState(false);
  const [activeDropdowns, setActiveDropdowns] = useState({});
  const [isHeaderScrolled, setIsHeaderScrolled] = useState(false);
  const searchInputRef = useRef(null);
  const navigate = useNavigate();

  // Search data
  const searchData = {
    'Mars Exploration': { type: 'Mission', path: '/missions' },
    'Lunar Base': { type: 'Mission', path: '/missions' },
    'Asteroid Mining': { type: 'Mission', path: '/missions' },
    'Jupiter Probe': { type: 'Mission', path: '/missions' },
    'Solar Sailing': { type: 'Mission', path: '/missions' },
    'Upcoming Launches': { type: 'Launch', path: '/launches' },
    'Past Launches': { type: 'Launch', path: '/launches' },
    'Live Stream': { type: 'Launch', path: '/launches' },
    'Launch Sites': { type: 'Launch', path: '/launches' },
    'Communication Satellites': { type: 'Satellite', path: '/satellites' },
    'Navigation': { type: 'Satellite', path: '/satellites' },
    'Earth Observation': { type: 'Satellite', path: '/satellites' },
    'Space Telescopes': { type: 'Satellite', path: '/satellites' },
    'Latest News': { type: 'Blog', path: '/blog' },
    'Tech Updates': { type: 'Blog', path: '/blog' },
    'Space Science': { type: 'Blog', path: '/blog' },
    'Mission Reports': { type: 'Blog', path: '/blog' },
    'Space Photos': { type: 'Gallery', path: '/gallery' },
    'Mission Videos': { type: 'Gallery', path: '/gallery' },
    '3D Models': { type: 'Gallery', path: '/gallery' },
    'Infographics': { type: 'Gallery', path: '/gallery' },
    'Our Team': { type: 'About', path: '/about' },
    'History': { type: 'About', path: '/about' },
    'Careers': { type: 'About', path: '/about' },
    'Contact Us': { type: 'About', path: '/about' }
  };

  // Handle search suggestions
  const showSearchSuggestions = (query) => {
    const filtered = Object.keys(searchData).filter(item =>
      item.toLowerCase().includes(query.toLowerCase())
    ).slice(0, 5);
    
    if (filtered.length > 0 && query.length > 0) {
      setShowSuggestions(true);
      return filtered;
    } else {
      setShowSuggestions(false);
      return [];
    }
  };

  const navigateToPage = (path) => {
    navigate(path);
    setIsSearchActive(false);
    setShowSuggestions(false);
    setSearchQuery('');
    setIsMobileMenuActive(false);
    document.body.style.overflow = '';
  };

  // Toggle mobile menu
  const toggleMobileMenu = () => {
    setIsMobileMenuActive(!isMobileMenuActive);
    if (isSearchActive) {
      setIsSearchActive(false);
      setShowSuggestions(false);
    }
    if (!isMobileMenuActive) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  };

  // Toggle dropdown
  const toggleDropdown = (index) => {
    setActiveDropdowns(prev => ({
      ...prev,
      [index]: !prev[index]
    }));
  };

  // Handle search icon click
  const handleSearchClick = () => {
    setIsSearchActive(!isSearchActive);
    if (!isSearchActive) {
      setTimeout(() => searchInputRef.current?.focus(), 100);
    } else {
      setShowSuggestions(false);
    }
  };

  // Handle search input
  const handleSearchInput = (e) => {
    const value = e.target.value;
    setSearchQuery(value);
    showSearchSuggestions(value);
  };

  // Handle search enter
  const handleSearchEnter = (e) => {
    if (e.key === 'Enter') {
      const query = e.target.value.toLowerCase();
      const found = Object.keys(searchData).find(item =>
        item.toLowerCase().includes(query)
      );
      if (found) {
        navigateToPage(searchData[found].path);
      }
    }
  };

  // Effects
  useEffect(() => {
    const handleScroll = () => {
      setIsHeaderScrolled(window.scrollY > 50);
    };

    const handleClickOutside = (e) => {
      if (isSearchActive && !e.target.closest('.search-container')) {
        setIsSearchActive(false);
        setShowSuggestions(false);
      }
    };

    const handleKeyDown = (e) => {
      if (e.key === 'Escape') {
        if (isSearchActive) {
          setIsSearchActive(false);
          setShowSuggestions(false);
        }
        if (isMobileMenuActive) {
          setIsMobileMenuActive(false);
          document.body.style.overflow = '';
          setActiveDropdowns({});
        }
      }
    };

    const handleResize = () => {
      if (window.innerWidth > 992) {
        setIsMobileMenuActive(false);
        document.body.style.overflow = '';
        setActiveDropdowns({});
      }
    };

    window.addEventListener('scroll', handleScroll);
    document.addEventListener('click', handleClickOutside);
    document.addEventListener('keydown', handleKeyDown);
    window.addEventListener('resize', handleResize);

    return () => {
      window.removeEventListener('scroll', handleScroll);
      document.removeEventListener('click', handleClickOutside);
      document.removeEventListener('keydown', handleKeyDown);
      window.removeEventListener('resize', handleResize);
      document.body.style.overflow = '';
    };
  }, [isSearchActive, isMobileMenuActive]);

  const suggestions = showSuggestions ? showSearchSuggestions(searchQuery) : [];

  return (
    <>
      <header className={isHeaderScrolled ? 'scrolled' : ''}>
        <div className="logo-container">
          <div className="logo-img">
            <span style={{ fontSize: '24px' }}>🚀</span>
          </div>
          <Link to="/" className="brand" style={{ textDecoration: 'none' }}>VoltVoyage</Link>
        </div>

        <nav>
          <ul className={`nav-links ${isMobileMenuActive ? 'active' : ''}`} ref={useRef(null)}>
            <li className="nav-item">
              <Link to="/" className="nav-link" onClick={() => navigateToPage('/')}>Home</Link>
            </li>
            
            <li className="nav-item">
              <span 
                className="nav-link" 
                onClick={() => toggleDropdown('missions')}
                style={{ cursor: 'pointer' }}
              >
                Missions
              </span>
              <ul className={`dropdown ${activeDropdowns['missions'] ? 'active' : ''}`}>
                <li className="dropdown-item">
                  <Link to="/missions" className="dropdown-link" onClick={() => navigateToPage('/missions')}>
                    Mars Exploration
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/missions" className="dropdown-link" onClick={() => navigateToPage('/missions')}>
                    Lunar Base
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/missions" className="dropdown-link" onClick={() => navigateToPage('/missions')}>
                    Asteroid Mining
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/missions" className="dropdown-link" onClick={() => navigateToPage('/missions')}>
                    Jupiter Probe
                  </Link>
                </li>
              </ul>
            </li>

            <li className="nav-item">
              <span 
                className="nav-link" 
                onClick={() => toggleDropdown('launches')}
                style={{ cursor: 'pointer' }}
              >
                Launches
              </span>
              <ul className={`dropdown ${activeDropdowns['launches'] ? 'active' : ''}`}>
                <li className="dropdown-item">
                  <Link to="/launches" className="dropdown-link" onClick={() => navigateToPage('/launches')}>
                    Upcoming Launches
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/launches" className="dropdown-link" onClick={() => navigateToPage('/launches')}>
                    Past Launches
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/launches" className="dropdown-link" onClick={() => navigateToPage('/launches')}>
                    Live Stream
                  </Link>
                </li>
              </ul>
            </li>

            <li className="nav-item">
              <span 
                className="nav-link" 
                onClick={() => toggleDropdown('satellites')}
                style={{ cursor: 'pointer' }}
              >
                Satellites
              </span>
              <ul className={`dropdown ${activeDropdowns['satellites'] ? 'active' : ''}`}>
                <li className="dropdown-item">
                  <Link to="/satellites" className="dropdown-link" onClick={() => navigateToPage('/satellites')}>
                    Communication
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/satellites" className="dropdown-link" onClick={() => navigateToPage('/satellites')}>
                    Navigation
                  </Link>
                </li>
                <li className="dropdown-item">
                  <Link to="/satellites" className="dropdown-link" onClick={() => navigateToPage('/satellites')}>
                    Earth Observation
                  </Link>
                </li>
              </ul>
            </li>

            <li className="nav-item">
              <Link to="/blog" className="nav-link" onClick={() => navigateToPage('/blog')}>Blog</Link>
            </li>

            <li className="nav-item">
              <Link to="/gallery" className="nav-link" onClick={() => navigateToPage('/gallery')}>Gallery</Link>
            </li>

            <li className="nav-item">
              <Link to="/about" className="nav-link" onClick={() => navigateToPage('/about')}>About</Link>
            </li>
          </ul>
        </nav>

        <div className="nav-right">
          <div className="search-container">
            <input
              ref={searchInputRef}
              type="text"
              className={`search-input ${isSearchActive ? 'active' : ''}`}
              placeholder="Search..."
              value={searchQuery}
              onChange={handleSearchInput}
              onKeyPress={handleSearchEnter}
            />
            <div className={`search-suggestions ${showSuggestions ? 'show' : ''}`}>
              {suggestions.map((item, index) => (
                <div
                  key={index}
                  className="suggestion-item"
                  onClick={() => navigateToPage(searchData[item].path)}
                >
                  <div>{item}</div>
                  <span className="suggestion-category">{searchData[item].type}</span>
                </div>
              ))}
            </div>
            <div className="search-icon" onClick={handleSearchClick}>
              <i className="fas fa-search"></i>
            </div>
          </div>
          
          <div className="user-icon">
            <i className="fas fa-user"></i>
          </div>

          <div 
            className={`menu-toggle ${isMobileMenuActive ? 'active' : ''}`}
            onClick={toggleMobileMenu}
          >
            <span></span>
          </div>
        </div>

        <div 
          className={`mobile-overlay ${isMobileMenuActive ? 'active' : ''}`}
          onClick={toggleMobileMenu}
        ></div>
      </header>
    </>
  );
};

// Home Page Content Component
const HomeContent = () => {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // Simulate content loading
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 800);

    return () => clearTimeout(timer);
  }, []);

  // Create enhanced stars
  const createStars = () => {
    const stars = [];
    for (let i = 0; i < 300; i++) {
      stars.push(
        <div
          key={i}
          className="star"
          style={{
            top: `${Math.random() * 100}%`,
            left: `${Math.random() * 100}%`,
            animationDelay: `${Math.random() * 4}s`
          }}
        ></div>
      );
    }
    return stars;
  };

  const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  if (isLoading) {
    return <SkeletonLoader />;
  }

  return (
    <div className="home-content">
      <div className="stars">{createStars()}</div>

      <section className="hero" id="home">
        <div className="hero-overlay"></div>
        <div className="hero-content">
          <h1 className="hero-text">
            🚧 Platform is under maintenance—launching soon. 🚧
          </h1>
          <p className="hero-subtitle">
            "Innovation Beyond Boundaries - India's Private Space Revolution"
          </p>
        </div>
        <div className="scroll-indicator" onClick={() => scrollToSection('recent-updates')}>
          <i className="fas fa-chevron-down"></i>
        </div>
      </section>

      <div className="section-divider"></div>

      <section className="recent-sections" id="recent-updates">
        <div className="recent-section">
          <h2 className="section-title">Recent Updates</h2>
          <div className="news-item">
            <h3 className="news-title">Successful Mars Rover Deployment</h3>
            <p className="news-date">October 20, 2025</p>
            <p className="news-excerpt">
              Our latest Mars rover has successfully landed in the Jezero Crater, beginning its mission to search for signs of ancient microbial life.
            </p>
          </div>
          <div className="news-item">
            <h3 className="news-title">New Communication Satellite Launch</h3>
            <p className="news-date">October 15, 2025</p>
            <p className="news-excerpt">
              The GSAT-30 communications satellite was successfully launched, enhancing connectivity across the Asia-Pacific region.
            </p>
          </div>
          <div className="news-item">
            <h3 className="news-title">Lunar Base Construction Begins</h3>
            <p className="news-date">October 10, 2025</p>
            <p className="news-excerpt">
              Construction of the first permanent lunar base has commenced, marking a significant milestone in human space exploration.
            </p>
          </div>
        </div>

        <div className="recent-section">
          <h2 className="section-title">Recent Launch</h2>
          <div className="launch-item">
            <div className="launch-image">
              <span style={{ fontSize: '80px' }}>🚀</span>
            </div>
            <h3 className="launch-title">PSLV-C58 Mission</h3>
            <p className="launch-description">
              Successfully deployed XpoSat, India's first X-ray Polarimeter Satellite, into orbit. The mission aims to study cosmic X-ray sources and black holes.
            </p>
            <Link to="/launches" className="launch-btn">View Details</Link>
          </div>
        </div>
      </section>

      <div className="section-divider"></div>

      <section className="private-space-section">
        <div className="section-container">
          <h2 className="section-main-title">Private Space Companies</h2>
          <p className="section-quote">
            "Innovation Beyond Boundaries - India's Private Space Revolution"
          </p>

          <div className="private-companies">
            <div className="company-card">
              <div className="company-logo">
                <div className="logo-fallback">AG</div>
              </div>
              <div className="company-info">
                <h3 className="company-name">Agnikul Cosmos</h3>
                <p className="company-desc">Launch Vehicles</p>
              </div>
              <div className="company-arrow">
                <i className="fas fa-arrow-right"></i>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <div className="logo-fallback">SK</div>
              </div>
              <div className="company-info">
                <h3 className="company-name">Skyroot Aerospace</h3>
                <p className="company-desc">Launch Services</p>
              </div>
              <div className="company-arrow">
                <i className="fas fa-arrow-right"></i>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <div className="logo-fallback">PX</div>
              </div>
              <div className="company-info">
                <h3 className="company-name">Pixxel</h3>
                <p className="company-desc">Earth Imaging</p>
              </div>
              <div className="company-arrow">
                <i className="fas fa-arrow-right"></i>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <div className="logo-fallback">DH</div>
              </div>
              <div className="company-info">
                <h3 className="company-name">Dhruva Space</h3>
                <p className="company-desc">Satellite Platforms</p>
              </div>
              <div className="company-arrow">
                <i className="fas fa-arrow-right"></i>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <div className="logo-fallback">BL</div>
              </div>
              <div className="company-info">
                <h3 className="company-name">Bellatrix Aerospace</h3>
                <p className="company-desc">Propulsion Systems</p>
              </div>
              <div className="company-arrow">
                <i className="fas fa-arrow-right"></i>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

// Main App Component
const VoltVoyage = () => {
  return (
    <Router>
      <div className="app">
        <Navigation />
        <Suspense fallback={<SkeletonLoader />}>
          <Routes>
            <Route path="/" element={<HomeContent />} />
            <Route path="/missions" element={<MissionsPage />} />
            <Route path="/launches" element={<LaunchesPage />} />
            <Route path="/satellites" element={<SatellitesPage />} />
            <Route path="/blog" element={<BlogPage />} />
            <Route path="/gallery" element={<GalleryPage />} />
            <Route path="/about" element={<AboutPage />} />
          </Routes>
        </Suspense>
      </div>
    </Router>
  );
};

export default VoltVoyage;
