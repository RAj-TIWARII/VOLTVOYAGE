import React, { useState, useEffect, useRef } from 'react';
import './App.css';

const VoltVoyage = () => {
  const [isSearchActive, setIsSearchActive] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [showSuggestions, setShowSuggestions] = useState(false);
  const [isMobileMenuActive, setIsMobileMenuActive] = useState(false);
  const [activeDropdowns, setActiveDropdowns] = useState({});
  const [isHeaderScrolled, setIsHeaderScrolled] = useState(false);

  const searchInputRef = useRef(null);
  const navLinksRef = useRef(null);

  // Search data
  const searchData = {
    'Mars Exploration': { type: 'Mission', href: '#mars-exploration' },
    'Lunar Base': { type: 'Mission', href: '#lunar-base' },
    'Asteroid Mining': { type: 'Mission', href: '#asteroid-mining' },
    'Jupiter Probe': { type: 'Mission', href: '#jupiter-probe' },
    'Solar Sailing': { type: 'Mission', href: '#solar-sailing' },
    'Upcoming Launches': { type: 'Launch', href: '#upcoming' },
    'Past Launches': { type: 'Launch', href: '#past-launches' },
    'Live Stream': { type: 'Launch', href: '#live-stream' },
    'Launch Sites': { type: 'Launch', href: '#launch-sites' },
    'Communication Satellites': { type: 'Satellite', href: '#communication' },
    'Navigation': { type: 'Satellite', href: '#navigation' },
    'Earth Observation': { type: 'Satellite', href: '#earth-observation' },
    'Space Telescopes': { type: 'Satellite', href: '#space-telescopes' },
    'Latest News': { type: 'Blog', href: '#latest-news' },
    'Tech Updates': { type: 'Blog', href: '#tech-updates' },
    'Space Science': { type: 'Blog', href: '#space-science' },
    'Mission Reports': { type: 'Blog', href: '#mission-reports' },
    'Space Photos': { type: 'Gallery', href: '#space-photos' },
    'Mission Videos': { type: 'Gallery', href: '#mission-videos' },
    '3D Models': { type: 'Gallery', href: '#3d-models' },
    'Infographics': { type: 'Gallery', href: '#infographics' },
    'Our Team': { type: 'About', href: '#our-team' },
    'History': { type: 'About', href: '#history' },
    'Careers': { type: 'About', href: '#careers' },
    'Contact Us': { type: 'About', href: '#contact-us' },
    'Home': { type: 'Page', href: '#home' },
    'Recent Updates': { type: 'Page', href: '#recent-updates' },
    'About': { type: 'Page', href: '#about' }
  };

  // Create enhanced stars with more variety and density
  const createStars = () => {
    const stars = [];
    // Increased number of stars for better coverage
    for (let i = 0; i < 300; i++) {
      stars.push(
        <div
          key={i}
          className="star"
          style={{
            left: `${Math.random() * 100}%`,
            top: `${Math.random() * 100}%`,
            animationDelay: `${Math.random() * 6}s`,
            animationDuration: `${3 + Math.random() * 4}s`
          }}
        />
      );
    }
    return stars;
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

  const navigateToSection = (href) => {
    const element = document.querySelector(href);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
    setIsSearchActive(false);
    setShowSuggestions(false);
    setSearchQuery('');
  };

  const scrollToSection = (id) => {
    const element = document.getElementById(id);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // Toggle mobile menu
  const toggleMobileMenu = () => {
    setIsMobileMenuActive(!isMobileMenuActive);
    if (isSearchActive) {
      setIsSearchActive(false);
      setShowSuggestions(false);
    }
    // Prevent body scroll when menu is open
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
        navigateToSection(searchData[found].href);
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
      // Prevent F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
      if (e.key === 'F12') e.preventDefault();
      if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) e.preventDefault();
      if (e.ctrlKey && e.key === 'U') e.preventDefault();
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
    <div className="app">
      {/* Enhanced Stars Background */}
      <div className="stars" id="stars">
        {createStars()}
      </div>

      <div className={`mobile-overlay ${isMobileMenuActive ? 'active' : ''}`} onClick={toggleMobileMenu}></div>

      <header id="header" className={isHeaderScrolled ? 'scrolled' : ''}>
        <div className="logo-container">
          <div className="logo-img">
            <img 
              src="assets/voltvoyage.png" 
              alt="VOLTVOYAGE Logo" 
              onError={(e) => {
                e.target.parentElement.innerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:bold;">V</div>';
              }}
            />
          </div>
          <div className="brand">VOLTVOYAGE</div>
        </div>

        <ul className={`nav-links ${isMobileMenuActive ? 'active' : ''}`} ref={navLinksRef}>
          <li className="nav-item">
            <a href="#home" className="nav-link">HOME</a>
          </li>
          <li className="nav-item">
            <a 
              href="#missions" 
              className="nav-link"
              onClick={(e) => {
                e.preventDefault();
                toggleDropdown('missions');
              }}
            >
              MISSIONS
            </a>
            <ul className={`dropdown ${activeDropdowns.missions ? 'active' : ''}`}>
              <li className="dropdown-item">
                <a href="chandryaan" className="dropdown-link">
                  Chandryaan <span style={{color: 'rgba(255, 255, 255, 0.479)'}}>(MOON)</span>
                </a>
              </li>
              <li className="dropdown-item">
                <a href="mangalyaan" className="dropdown-link">
                  Mangalyaan <span style={{color: 'rgba(255, 255, 255, 0.479)'}}>(MARS)</span>
                </a>
              </li>
              <li className="dropdown-item">
                <a href="gaganyaan" className="dropdown-link">
                  Gaganyaan <span style={{color: 'rgba(255, 255, 255, 0.479)'}}>(CREW)</span>
                </a>
              </li>
              <li className="dropdown-item">
                <a href="#jupiter-probe" className="dropdown-link">
                  Sukrayaaan <span style={{color: 'rgba(255, 255, 255, 0.479)'}}>(VENUS)</span>
                </a>
              </li>
              <li className="dropdown-item">
                <a href="rlv" className="dropdown-link">RLV-LEX</a>
              </li>
            </ul>
          </li>
          <li className="nav-item">
            <a 
              href="#launches" 
              className="nav-link"
              onClick={(e) => {
                e.preventDefault();
                toggleDropdown('launches');
              }}
            >
              LAUNCHES
            </a>
            <ul className={`dropdown ${activeDropdowns.launches ? 'active' : ''}`}>
              <li className="dropdown-item"><a href="#upcoming" className="dropdown-link">Upcoming</a></li>
              <li className="dropdown-item"><a href="#past-launches" className="dropdown-link">Past Launches</a></li>
              <li className="dropdown-item"><a href="#live-stream" className="dropdown-link">Live Stream</a></li>
              <li className="dropdown-item"><a href="#launch-sites" className="dropdown-link">Launch Sites</a></li>
            </ul>
          </li>
          <li className="nav-item">
            <a 
              href="#satellite" 
              className="nav-link"
              onClick={(e) => {
                e.preventDefault();
                toggleDropdown('satellite');
              }}
            >
              SATELLITE
            </a>
            <ul className={`dropdown ${activeDropdowns.satellite ? 'active' : ''}`}>
              <li className="dropdown-item"><a href="#communication" className="dropdown-link">Communication</a></li>
              <li className="dropdown-item"><a href="#navigation" className="dropdown-link">Navigation</a></li>
              <li className="dropdown-item"><a href="#earth-observation" className="dropdown-link">Earth Observation</a></li>
              <li className="dropdown-item"><a href="#space-telescopes" className="dropdown-link">Space Telescopes</a></li>
            </ul>
          </li>
          <li className="nav-item">
            <a 
              href="#blog" 
              className="nav-link"
              onClick={(e) => {
                e.preventDefault();
                toggleDropdown('blog');
              }}
            >
              BLOG
            </a>
            <ul className={`dropdown ${activeDropdowns.blog ? 'active' : ''}`}>
              <li className="dropdown-item"><a href="#latest-news" className="dropdown-link">Latest News</a></li>
              <li className="dropdown-item"><a href="#tech-updates" className="dropdown-link">Tech Updates</a></li>
              <li className="dropdown-item"><a href="#space-science" className="dropdown-link">Space Science</a></li>
              <li className="dropdown-item"><a href="#mission-reports" className="dropdown-link">Mission Reports</a></li>
            </ul>
          </li>
          <li className="nav-item">
            <a 
              href="#gallery" 
              className="nav-link"
              onClick={(e) => {
                e.preventDefault();
                toggleDropdown('gallery');
              }}
            >
              GALLERY
            </a>
            <ul className={`dropdown ${activeDropdowns.gallery ? 'active' : ''}`}>
              <li className="dropdown-item"><a href="#space-photos" className="dropdown-link">Space Photos</a></li>
              <li className="dropdown-item"><a href="#mission-videos" className="dropdown-link">Mission Videos</a></li>
              <li className="dropdown-item"><a href="#3d-models" className="dropdown-link">3D Models</a></li>
              <li className="dropdown-item"><a href="#infographics" className="dropdown-link">Infographics</a></li>
            </ul>
          </li>
          <li className="nav-item">
            <a 
              href="#about" 
              className="nav-link"
              onClick={(e) => {
                e.preventDefault();
                toggleDropdown('about');
              }}
            >
              ABOUT
            </a>
            <ul className={`dropdown ${activeDropdowns.about ? 'active' : ''}`}>
              <li className="dropdown-item"><a href="#our-team" className="dropdown-link">Our Team</a></li>
              <li className="dropdown-item"><a href="#history" className="dropdown-link">History</a></li>
              <li className="dropdown-item"><a href="#careers" className="dropdown-link">Careers</a></li>
              <li className="dropdown-item"><a href="#contact-us" className="dropdown-link">Contact Us</a></li>
            </ul>
          </li>
        </ul>

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
              autoComplete="off"
            />
            <div className={`search-suggestions ${showSuggestions ? 'show' : ''}`} id="searchSuggestions">
              {suggestions.map(item => (
                <div 
                  key={item}
                  className="suggestion-item" 
                  onClick={() => navigateToSection(searchData[item].href)}
                >
                  <div className="suggestion-category">{searchData[item].type}</div>
                  <div>{item}</div>
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
          <div className={`menu-toggle ${isMobileMenuActive ? 'active' : ''}`} onClick={toggleMobileMenu}>
            <span></span>
          </div>
        </div>
      </header>

      <section className="hero" id="home">
        <video 
          className="hero-video" 
          autoPlay 
          loop 
          muted 
          playsInline 
          preload="auto"
          onContextMenu={(e) => e.preventDefault()}
        >
          <source src="https://assets.mixkit.co/videos/preview/mixkit-earth-view-from-space-2251-large.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <div className="hero-overlay"></div>
        <div className="hero-content">
          <div className="hero-text">TRACKING INDIAN SPACE FLIGHT</div>
          <p className="hero-subtitle"></p>
<br></br>
          <p>🚧 Platform is under maintenance—launching soon. 🚧</p>
        </div>
        <div className="scroll-indicator" onClick={() => scrollToSection('recent-sections')}>
          <i className="fas fa-chevron-down"></i>
        </div>
      </section>

      <div className="recent-sections" id="recent-sections">
        <div className="recent-section">
          <h2 className="section-title">FLASH NEWS</h2>
          <div className="news-item">
            <div className="news-title">Gaganyaan Mission Air Drop Test (IADT-01)</div>
            <div className="news-date">August 24, 2025</div>
            <div className="news-excerpt">ISRO has successfully conducted the first Integrated Air Drop Test (IADT-01) of the Gaganyaan capsule.</div>
          </div>
          <div className="news-item">
            <div className="news-title">Gaganyaan Test Flight Success</div>
            <div className="news-date">August 10, 2025</div>
            <div className="news-excerpt">Successful completion of crew escape system test brings India closer to human spaceflight.</div>
          </div>
          <div className="news-item">
            <div className="news-title">NavIC Expansion Program</div>
            <div className="news-date">August 5, 2025</div>
            <div className="news-excerpt">India's navigation satellite constellation gets upgraded with next-generation positioning technology.</div>
          </div>
        </div>

        <div className="recent-section">
          <h2 className="section-title">RECENT LAUNCH</h2>
          <div className="launch-item">
            <div className="launch-image">
              <video autoPlay loop muted playsInline preload="auto" style={{width:'100%',height:'100%',objectFit:'cover',borderRadius:'15px'}}>
                <source src="launches/gslvf16.mp4" type="video/mp4" />
                <i className="fas fa-satellite"></i>
              </video>
            </div>
            <div className="launch-title">NISAR - NASA-ISRO Mission</div>
            <div className="launch-description">Joint Earth observation mission between NASA and ISRO to study climate change, natural disasters, and ecosystem disturbances using advanced radar technology.</div>
            <a href="nisar.html" className="launch-btn">Explore Mission</a>
          </div>
        </div>
      </div>

      <div className="section-divider"></div>

      <div style={{height: '200px', display: 'flex', alignItems: 'center', justifyContent: 'center', color: '#87ceeb', fontSize: '1.2rem'}}>
        {/* Future content will be added here */}
      </div>

      <section className="private-space-section">
        <div className="section-container">
          <h2 className="section-main-title">PRIVATE SPACE</h2>
          <p className="section-quote">"Innovation Beyond Boundaries - India's Private Space Revolution"</p>

          <div className="private-companies">
            <div className="company-card">
              <div className="company-logo">
                <img 
                  src="https://pbs.twimg.com/profile_images/1523877890143981570/wMGvioWU_400x400.jpg" 
                  alt="Skyroot" 
                  onError={(e) => {
                    e.target.parentElement.innerHTML = '<div class="logo-fallback">S</div>';
                  }}
                />
              </div>
              <div className="company-info">
                <div className="company-name skyroot">Skyroot Aerospace</div>
                <div className="company-desc">Launch Vehicle Development</div>
              </div>
              <div className="company-arrow">
                <a href="https://skyroot.in/" style={{textDecoration: 'none', color: 'gray'}} target="_blank" rel="noopener noreferrer">
                  <i className="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <img 
                  src="https://pbs.twimg.com/profile_images/969651847072854016/O1wofIxB_400x400.jpg" 
                  alt="Agnikul" 
                  onError={(e) => {
                    e.target.parentElement.innerHTML = '<div class="logo-fallback">A</div>';
                  }}
                />
              </div>
              <div className="company-info">
                <div className="company-name">Agnikul Cosmos</div>
                <div className="company-desc">3D Printed Rocket Engines</div>
              </div>
              <div className="company-arrow">
                <a href="https://agnikul.in/#/" style={{textDecoration: 'none', color: 'gray'}} target="_blank" rel="noopener noreferrer">
                  <i className="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <img 
                  src="https://pbs.twimg.com/profile_images/1889232679088132096/K2iQKAxp_400x400.jpg" 
                  alt="Pixxel" 
                  onError={(e) => {
                    e.target.parentElement.innerHTML = '<div class="logo-fallback">P</div>';
                  }}
                />
              </div>
              <div className="company-info">
                <div className="company-name">Pixxel</div>
                <div className="company-desc">Earth Imaging Satellites</div>
              </div>
              <div className="company-arrow">
                <a href="https://www.pixxel.space/" style={{textDecoration: 'none', color: 'gray'}} target="_blank" rel="noopener noreferrer">
                  <i className="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <img 
                  src="https://pbs.twimg.com/profile_images/1932042984830447616/Y02wMTBf_400x400.jpg" 
                  alt="Dhruv Space" 
                  onError={(e) => {
                    e.target.parentElement.innerHTML = '<div class="logo-fallback">D</div>';
                  }}
                />
              </div>
              <div className="company-info">
                <div className="company-name">Dhruv Space</div>
                <div className="company-desc">Satellite Ground Stations</div>
              </div>
              <div className="company-arrow">
                <a href="https://www.dhruvaspace.com/" style={{textDecoration: 'none', color: 'gray'}} target="_blank" rel="noopener noreferrer">
                  <i className="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>

            <div className="company-card">
              <div className="company-logo">
                <img 
                  src="https://pbs.twimg.com/profile_images/1142427965000523776/zDdP6ta-_400x400.jpg" 
                  alt="Bellatrix" 
                  onError={(e) => {
                    e.target.parentElement.innerHTML = '<div class="logo-fallback">B</div>';
                  }}
                />
              </div>
              <div className="company-info">
                <div className="company-name">Bellatrix Aerospace</div>
                <div className="company-desc">Electric Propulsion Systems</div>
              </div>
              <div className="company-arrow">
                <a href="https://bellatrix.aero/" style={{textDecoration: 'none', color: 'gray'}} target="_blank" rel="noopener noreferrer">
                  <i className="fas fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div className="section-divider"></div>
    </div>
  );
};

export default VoltVoyage;
