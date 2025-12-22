"use client";

import React, { useState } from 'react';
import { 
  Calendar, 
  User, 
  Clock, 
  Tag,
  Search,
  ChevronRight,
  TrendingUp,
  Heart,
  MessageCircle,
  Share2,
  Eye,
  ArrowRight
} from 'lucide-react';
import Link from 'next/link';

// Mock blog data
const blogPosts = [
  {
    id: 1,
    title: "10 Essential Skincare Tips for Glowing Skin",
    excerpt: "Discover the secrets to achieving radiant, healthy skin with our comprehensive guide to daily skincare routines and product recommendations.",
    image: "/assets/img/blog/blog1.png",
    category: "Skincare",
    author: "Sarah Johnson",
    date: "December 5, 2024",
    readTime: "5 min read",
    views: 1234,
    likes: 89,
    comments: 23,
    featured: true,
    tags: ["Skincare", "Beauty Tips", "Glow"]
  },
  {
    id: 2,
    title: "The Ultimate Guide to Choosing the Right Foundation",
    excerpt: "Finding your perfect foundation match doesn't have to be complicated. Learn the key factors to consider when selecting foundation for your skin type.",
    image: "/assets/img/blog/blog2.png",
    category: "Makeup",
    author: "Emily Chen",
    date: "December 3, 2024",
    readTime: "7 min read",
    views: 2156,
    likes: 145,
    comments: 34,
    featured: false,
    tags: ["Makeup", "Foundation", "Tutorial"]
  },
  {
    id: 3,
    title: "Natural Ingredients for Better Hair Care",
    excerpt: "Explore the power of natural ingredients and how they can transform your hair care routine for healthier, stronger locks.",
    image: "/assets/img/blog/blog3.png",
    category: "Hair Care",
    author: "Michael Brown",
    date: "December 1, 2024",
    readTime: "6 min read",
    views: 1876,
    likes: 112,
    comments: 28,
    featured: true,
    tags: ["Hair Care", "Natural", "DIY"]
  },
  {
    id: 4,
    title: "Anti-Aging Secrets: Look Younger Naturally",
    excerpt: "Discover proven anti-aging techniques and products that can help you maintain youthful, vibrant skin without expensive procedures.",
    image: "/assets/img/blog/blog4.png",
    category: "Anti-Aging",
    author: "Dr. Lisa Wang",
    date: "November 28, 2024",
    readTime: "8 min read",
    views: 3421,
    likes: 256,
    comments: 67,
    featured: false,
    tags: ["Anti-Aging", "Skincare", "Beauty"]
  },
  {
    id: 5,
    title: "Summer Makeup Trends You Need to Try",
    excerpt: "Get ready for summer with the hottest makeup trends of the season. From bold lips to dewy skin, we've got you covered.",
    image: "/assets/img/blog/blog1.png",
    category: "Makeup",
    author: "Jessica Martinez",
    date: "November 25, 2024",
    readTime: "4 min read",
    views: 1654,
    likes: 98,
    comments: 19,
    featured: false,
    tags: ["Makeup", "Trends", "Summer"]
  },
  {
    id: 6,
    title: "The Science Behind Vitamin C Serums",
    excerpt: "Understanding how vitamin C works in skincare products and why it should be a staple in your routine for brighter, healthier skin.",
    image: "/assets/img/blog/blog2.png",
    category: "Skincare",
    author: "Dr. Amanda Lee",
    date: "November 22, 2024",
    readTime: "10 min read",
    views: 2890,
    likes: 187,
    comments: 45,
    featured: true,
    tags: ["Skincare", "Vitamin C", "Science"]
  },
  {
    id: 7,
    title: "Cruelty-Free Beauty: Brands You Can Trust",
    excerpt: "Explore the world of cruelty-free cosmetics and discover brands that are committed to ethical beauty practices.",
    image: "/assets/img/blog/blog3.png",
    category: "Ethical Beauty",
    author: "Rachel Green",
    date: "November 20, 2024",
    readTime: "6 min read",
    views: 1432,
    likes: 76,
    comments: 31,
    featured: false,
    tags: ["Cruelty-Free", "Ethical", "Brands"]
  },
  {
    id: 8,
    title: "Evening Skincare Routine for Perfect Skin",
    excerpt: "Learn how to create the perfect nighttime skincare routine that works while you sleep for glowing morning skin.",
    image: "/assets/img/blog/blog4.png",
    category: "Skincare",
    author: "Olivia Thompson",
    date: "November 18, 2024",
    readTime: "5 min read",
    views: 2103,
    likes: 134,
    comments: 28,
    featured: false,
    tags: ["Skincare", "Routine", "Night Care"]
  }
];

const categories = [
  { name: "All Posts", count: 48 },
  { name: "Skincare", count: 18 },
  { name: "Makeup", count: 15 },
  { name: "Hair Care", count: 8 },
  { name: "Anti-Aging", count: 5 },
  { name: "Ethical Beauty", count: 2 }
];

const popularTags = [
  "Skincare", "Makeup", "Beauty Tips", "Tutorial", "Natural",
  "Anti-Aging", "Hair Care", "Cruelty-Free", "Korean Beauty", "DIY"
];

const Blog = () => {
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('All Posts');

  const featuredPost = blogPosts.find(post => post.featured);
  const recentPosts = blogPosts.slice(0, 3);

  return (
    <div className="bg-gradient-to-b from-pink-50/30 to-white min-h-screen">
      {/* Hero Section */}
      <div className="bg-gradient-to-r from-pink-600 to-rose-600 text-white py-16">
        <div className="max-w-7xl mx-auto px-[5%]">
          <h1 className="text-4xl md:text-5xl font-bold mb-4 text-center">Beauty & Wellness Blog</h1>
          <p className="text-xl text-center text-pink-50 max-w-2xl mx-auto mb-8">
            Expert tips, trends, and tutorials to help you look and feel your best
          </p>
          
          {/* Search Bar */}
          <div className="max-w-2xl mx-auto">
            <div className="relative">
              <input
                type="text"
                placeholder="Search articles, tips, tutorials..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="w-full px-6 py-4 pl-14 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-pink-300 shadow-lg"
              />
              <Search className="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-[5%] py-12">
        <div className="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">
          
          {/* Main Content */}
          <div>
            {/* Featured Post */}
            {featuredPost && (
              <div className="mb-12">
                <div className="flex items-center gap-2 mb-4">
                  <TrendingUp className="w-5 h-5 text-pink-600" />
                  <h2 className="text-2xl font-bold text-gray-900">Featured Article</h2>
                </div>
                
                <Link href={`/blog/${featuredPost.id}`} className="cursor-pointer">
                  <div className="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                    <div className="relative aspect-[21/10] overflow-hidden">
                      <img
                        src={featuredPost.image}
                        alt={featuredPost.title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      />
                      <div className="absolute top-4 left-4">
                        <span className="px-4 py-1.5 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm font-bold rounded-full">
                          Featured
                        </span>
                      </div>
                    </div>
                    
                    <div className="p-8">
                      <div className="flex items-center gap-4 text-sm text-gray-600 mb-4">
                        <span className="px-3 py-1 bg-pink-100 text-pink-600 rounded-full font-semibold">
                          {featuredPost.category}
                        </span>
                        <div className="flex items-center gap-1">
                          <Calendar className="w-4 h-4" />
                          {featuredPost.date}
                        </div>
                        <div className="flex items-center gap-1">
                          <Clock className="w-4 h-4" />
                          {featuredPost.readTime}
                        </div>
                      </div>
                      
                      <h3 className="text-3xl font-bold text-gray-900 mb-3 group-hover:text-pink-600 transition-colors">
                        {featuredPost.title}
                      </h3>
                      
                      <p className="text-gray-600 mb-6 line-clamp-2">
                        {featuredPost.excerpt}
                      </p>
                      
                      <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                          <div className="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white font-bold">
                            {featuredPost.author.charAt(0)}
                          </div>
                          <div>
                            <p className="font-semibold text-gray-900 text-sm">{featuredPost.author}</p>
                            <p className="text-xs text-gray-500">Author</p>
                          </div>
                        </div>
                        
                        <div className="flex items-center gap-4 text-sm text-gray-500">
                          <div className="flex items-center gap-1">
                            <Eye className="w-4 h-4" />
                            {featuredPost.views}
                          </div>
                          <div className="flex items-center gap-1">
                            <Heart className="w-4 h-4" />
                            {featuredPost.likes}
                          </div>
                          <div className="flex items-center gap-1">
                            <MessageCircle className="w-4 h-4" />
                            {featuredPost.comments}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </Link>
              </div>
            )}

            {/* Category Filter */}
            <div className="flex items-center gap-3 mb-8 overflow-x-auto pb-2">
              {categories.map((category, index) => (
                <button
                  key={index}
                  onClick={() => setSelectedCategory(category.name)}
                  className={`px-4 py-2 rounded-full font-semibold whitespace-nowrap transition-all cursor-pointer ${
                    selectedCategory === category.name
                      ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white shadow-lg'
                      : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'
                  }`}
                >
                  {category.name} ({category.count})
                </button>
              ))}
            </div>

            {/* Blog Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {blogPosts.map((post) => (
                <Link key={post.id} href={`/blog/${post.id}`} className="cursor-pointer">
                  <div className="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all group h-full flex flex-col">
                    <div className="relative aspect-[16/10] overflow-hidden">
                      <img
                        src={post.image}
                        alt={post.title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      />
                      <div className="absolute top-3 left-3">
                        <span className="px-3 py-1 bg-white/90 backdrop-blur-sm text-pink-600 text-xs font-bold rounded-full">
                          {post.category}
                        </span>
                      </div>
                    </div>
                    
                    <div className="p-5 flex-1 flex flex-col">
                      <div className="flex items-center gap-3 text-xs text-gray-500 mb-3">
                        <div className="flex items-center gap-1">
                          <Calendar className="w-3.5 h-3.5" />
                          {post.date}
                        </div>
                        <div className="flex items-center gap-1">
                          <Clock className="w-3.5 h-3.5" />
                          {post.readTime}
                        </div>
                      </div>
                      
                      <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors line-clamp-2">
                        {post.title}
                      </h3>
                      
                      <p className="text-gray-600 text-sm mb-4 line-clamp-2 flex-1">
                        {post.excerpt}
                      </p>
                      
                      <div className="flex items-center justify-between pt-4 border-t">
                        <div className="flex items-center gap-2">
                          <div className="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {post.author.charAt(0)}
                          </div>
                          <span className="text-sm font-medium text-gray-700">{post.author}</span>
                        </div>
                        
                        <div className="flex items-center gap-3 text-xs text-gray-500">
                          <div className="flex items-center gap-1">
                            <Heart className="w-3.5 h-3.5" />
                            {post.likes}
                          </div>
                          <div className="flex items-center gap-1">
                            <MessageCircle className="w-3.5 h-3.5" />
                            {post.comments}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </Link>
              ))}
            </div>

            {/* Load More Button */}
            <div className="text-center mt-12">
              <button className="px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-600 hover:to-rose-700 text-white font-bold rounded-xl transition-all shadow-lg hover:scale-105 cursor-pointer inline-flex items-center gap-2">
                Load More Articles
                <ArrowRight className="w-5 h-5" />
              </button>
            </div>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* About Widget */}
            <div className="bg-white rounded-xl shadow-md p-6">
              <h3 className="text-xl font-bold text-gray-900 mb-4">About This Blog</h3>
              <p className="text-gray-600 text-sm leading-relaxed mb-4">
                Your go-to source for beauty tips, skincare advice, and the latest trends in cosmetics. We're passionate about helping you discover your best self.
              </p>
              <Link href="/about" className="text-pink-600 hover:text-pink-700 font-semibold text-sm inline-flex items-center gap-1 cursor-pointer">
                Learn More
                <ChevronRight className="w-4 h-4" />
              </Link>
            </div>

            {/* Recent Posts */}
            <div className="bg-white rounded-xl shadow-md p-6">
              <h3 className="text-xl font-bold text-gray-900 mb-4">Recent Posts</h3>
              <div className="space-y-4">
                {recentPosts.map((post) => (
                  <Link key={post.id} href={`/blog/${post.id}`} className="cursor-pointer">
                    <div className="flex gap-3 group">
                      <img
                        src={post.image}
                        alt={post.title}
                        className="w-20 h-20 object-cover rounded-lg flex-shrink-0"
                      />
                      <div className="flex-1 min-w-0">
                        <h4 className="font-semibold text-sm text-gray-900 group-hover:text-pink-600 transition-colors line-clamp-2 mb-1">
                          {post.title}
                        </h4>
                        <div className="flex items-center gap-2 text-xs text-gray-500">
                          <Calendar className="w-3 h-3" />
                          {post.date}
                        </div>
                      </div>
                    </div>
                  </Link>
                ))}
              </div>
            </div>

            {/* Categories Widget */}
            <div className="bg-white rounded-xl shadow-md p-6">
              <h3 className="text-xl font-bold text-gray-900 mb-4">Categories</h3>
              <div className="space-y-2">
                {categories.map((category, index) => (
                  <button
                    key={index}
                    onClick={() => setSelectedCategory(category.name)}
                    className={`w-full flex items-center justify-between px-4 py-2.5 rounded-lg transition-colors cursor-pointer ${
                      selectedCategory === category.name
                        ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white'
                        : 'bg-gray-50 text-gray-700 hover:bg-gray-100'
                    }`}
                  >
                    <span className="font-medium text-sm">{category.name}</span>
                    <span className="text-sm opacity-80">({category.count})</span>
                  </button>
                ))}
              </div>
            </div>

            {/* Popular Tags */}
            <div className="bg-white rounded-xl shadow-md p-6">
              <h3 className="text-xl font-bold text-gray-900 mb-4">Popular Tags</h3>
              <div className="flex flex-wrap gap-2">
                {popularTags.map((tag, index) => (
                  <button
                    key={index}
                    className="px-3 py-1.5 bg-gray-100 hover:bg-gradient-to-r hover:from-pink-500 hover:to-rose-600 hover:text-white text-gray-700 text-sm rounded-full transition-all cursor-pointer"
                  >
                    #{tag}
                  </button>
                ))}
              </div>
            </div>

            {/* Newsletter Signup */}
            <div className="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl shadow-md p-6 text-white">
              <h3 className="text-xl font-bold mb-2">Stay Updated!</h3>
              <p className="text-pink-50 text-sm mb-4">
                Subscribe to get the latest beauty tips and trends delivered to your inbox.
              </p>
              <div className="space-y-3">
                <input
                  type="email"
                  placeholder="Enter your email"
                  className="w-full px-4 py-2.5 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white"
                />
                <button className="w-full py-2.5 bg-white text-pink-600 font-bold rounded-lg hover:bg-pink-50 transition-colors cursor-pointer">
                  Subscribe Now
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Blog;