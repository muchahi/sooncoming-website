@extends('layouts.main')

@section('content')

<section class="about-us-section py-5">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    .about-us-section {
      background: linear-gradient(135deg, #f3f4f6, #e5e7eb, #f9fafb);
      font-family: 'Inter', sans-serif;
    }

    .about-us-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
      padding: 0 1rem;
      max-width: 1200px;
      margin: auto;
    }

    .info-card {
      background: linear-gradient(135deg, #ffffffcc, #f0f0f0e0);
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      padding: 2rem 1rem 2.5rem;
      text-align: center;
      position: relative;
      transition: all 0.4s ease;
      overflow: hidden;
    }

    .info-card:hover {
      background: linear-gradient(135deg, #fef3c7, #fde68a);
      transform: translateY(-8px);
      box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
    }

    .info-card i {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: #6b7280;
    }

    .info-card h3 {
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #111827;
    }

    .info-card p {
      font-size: 0.95rem;
      color: #374151;
    }

    .social-icons {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  margin-top: 1.5rem;
  flex-wrap: wrap;
}

.social-icons a {
  font-size: 0.85rem; /* reduced font size */
  color: white;
  padding: 0.4rem 0.75rem;
  border-radius: 20px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  text-decoration: none;
  font-weight: 600;
}

    .social-icons a:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
    }

    .social-icons a.instagram { background: linear-gradient(135deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5); }
    .social-icons a.facebook { background: #1877f2; }
    .social-icons a.tiktok { background: linear-gradient(135deg, #25f4ee, #000000, #fe2c55); }
    .social-icons a.whatsapp { background: #25d366; }

    @media (max-width: 768px) {
      .info-card {
        padding: 1.5rem 1rem 2rem;
      }
    }
  </style>

  <div class="about-us-grid">
    <div class="info-card">
      <i class="fas fa-info-circle"></i>
      <h3>About SoonComing</h3>
      <p>We’re a modern ecommerce store that brings you the best tech gadgets at unbeatable prices — delivering excellence, reliability, and innovation right to your doorstep.</p>
    </div>

    <div class="info-card">
      <i class="fas fa-map-marker-alt"></i>
      <h3>Location & Contact</h3>
      <p>
         Call Us: +254704136678<br>
        📧 Email: <a href="mailto:shop@sooncomming.co.ke">shop@sooncomming.co.ke</a><br>
         Pioneer House, 6th Floor, Room 2,<br>
        Next to Nation Centre, Kimathi Street.<br>
        Ask for Amoh at the reception.
      </p>
    </div>

    <div class="info-card">
      <i class="fas fa-cogs"></i>
      <h3>Our Services</h3>
      <p>Tech Gadgets, Accessories, Timely Delivery, Order Tracking and Exceptional Customer Support. We aim to elevate your shopping experience.</p>
    </div>

    <div class="info-card">
      <i class="fas fa-shield-alt"></i>
      <h3>Terms & Policies</h3>
      <p>Review our clear and transparent policies for returns, delivery, and user data protection. We value your trust and safety.</p>
    </div>

    <div class="info-card">
      <i class="fas fa-envelope-open-text"></i>
      <h3>Email & Support</h3>
      <p>Need help or inquiries? Contact us through our official email, and we’ll get back to you promptly. We’re always ready to help you!</p>
      <p>Official Email: <a href="mailto:shop@sooncomming.co.ke">shop@sooncomming.co.ke</a></p>
    </div>

    <div class="info-card">
  <i class="fas fa-share-alt"></i>
  <h3>Connect With Us</h3>
  <p>Follow us online and stay updated with offers, new arrivals, and tech trends. We love engaging with our community!</p>
  <div class="social-icons">
    <a href="https://www.instagram.com/soon_comming_" class="instagram" target="_blank" title="Instagram">Instagram</a>
    <a href="https://www.facebook.com/Soon Comming" class="facebook" target="_blank" title="Facebook">Facebook</a>
    <a href="https://www.tiktok.com/@_soon_comming" class="tiktok" target="_blank" title="TikTok">TikTok</a>
    <a href="https://wa.me/254704136678" class="whatsapp" target="_blank" title="WhatsApp">WhatsApp</a>
  </div>
</div>

  </div>
</section>


@endsection
