import { motion } from 'framer-motion'
import { Building2, Car, UserCheck } from 'lucide-react'

const statistics = [
  {
    percentage: "43%",
    source: "J.D. Power",
    text: "of online car shoppers rely on window stickers"
  },
  {
    percentage: "61%",
    source: "AutoTrader",
    text: "more likely to contact dealers with sticker info"
  },
  {
    percentage: "25%",
    source: "Cox Automotive",
    text: "boost in lead conversion with window stickers"
  }
]

const categories = [
  {
    title: "Buyers: Drive Informed",
    icon: Car,
    benefits: [
      "Spot the best deals with easy comparisons",
      "Avoid scams with verified vehicle info",
      "Make confident decisions with complete feature lists",
      "Compare efficiency and safety at a glance",
      "Negotiate like a pro with pricing insights"
    ]
  },
  {
    title: "Sellers: Showcase with Confidence",
    icon: UserCheck,
    benefits: [
      "Highlight your car's best features effortlessly",
      "Justify your price with transparent specs",
      "Build trust through comprehensive information"
    ]
  },
  {
    title: "Dealerships: Elevate Your Business",
    icon: Building2,
    benefits: [
      "Stay compliant with regulations effortlessly",
      "Stand out in a crowded market",
      "Boost customer loyalty with transparency",
      "Streamline operations with accurate info"
    ]
  }
]

export function BenefitsStatistics() {
  return (
    <section className="py-16">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold text-center mb-12">
          Window Stickers: Your Key to Smarter Car Buying
        </h2>

        <div className="grid gap-8 md:grid-cols-3 mb-16">
          {statistics.map((stat, index) => (
            <motion.div 
              key={index}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300"
              whileHover={{ scale: 1.05 }}
              transition={{ type: "spring", stiffness: 300 }}
            >
              <motion.div 
                className="text-4xl font-bold text-blue-600 mb-2"
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.2 }}
              >
                {stat.percentage}
              </motion.div>
              <div className="text-sm text-gray-600 mb-2">Source: {stat.source}</div>
              <p className="text-gray-800 font-medium">{stat.text}</p>
            </motion.div>
          ))}
        </div>

        <h3 className="text-2xl font-bold text-center mb-8">
          Empowering Every Step of the Car Journey
        </h3>

        <div className="grid gap-6 max-w-4xl mx-auto">
          {categories.map((category, index) => (
            <motion.div
              key={index}
              className="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden"
              whileHover={{ scale: 1.02 }}
              transition={{ type: "spring", stiffness: 300 }}
            >
              <div className="p-6">
                <div className="flex items-center gap-4 mb-4">
                  <span className="text-3xl text-blue-600"><category.icon className="w-6 h-6" /></span>
                  <h4 className="text-xl font-semibold text-blue-600">
                    {category.title}
                  </h4>
                </div>
                <ul className="space-y-3">
                  {category.benefits.map((benefit, i) => (
                    <motion.li 
                      key={i} 
                      className="flex items-start gap-2"
                      initial={{ opacity: 0, x: -20 }}
                      animate={{ opacity: 1, x: 0 }}
                      transition={{ delay: i * 0.1 }}
                    >
                      <svg className="h-5 w-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                      </svg>
                      <span className="text-gray-600">{benefit}</span>
                    </motion.li>
                  ))}
                </ul>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  )
}

