'use client'

import { useState } from 'react'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Textarea } from "@/components/ui/textarea"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Phone, Mail, MapPin, Clock, Send } from 'lucide-react'

export function ContactContent() {
  const [inquiryType, setInquiryType] = useState('')
  const [formSubmitted, setFormSubmitted] = useState(false) // New state to track form submission

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault() // Prevent default form submission
    setFormSubmitted(true) // Update state to show success message
    setTimeout(() => setFormSubmitted(false), 3000) // Optional: Hide message after 3 seconds
  }

  return (
    <div className="min-h-screen">
      <div className="container mx-auto px-4 py-12">
        <div className="text-center max-w-3xl mx-auto mb-12">
          <Badge variant="secondary" className="mb-4">
            Contact Us
          </Badge>
          <h1 className="text-4xl font-bold mb-4">
            Get in Touch with VehicleInsights
          </h1>
          <p className="text-lg text-gray-600">
            We&apos;re here to help with any questions about our vehicle history reports or window sticker services.
          </p>
        </div>

        <div className="grid md:grid-cols-2 gap-12">
          <Card>
            <CardHeader>
              <CardTitle>Send Us a Message</CardTitle>
            </CardHeader>
            <CardContent>
              <form className="space-y-4" onSubmit={handleSubmit}>
                <Input placeholder="Your Name" required />
                <Input type="email" placeholder="Your Email" required />
                <Select value={inquiryType} onValueChange={setInquiryType}>
                  <SelectTrigger>
                    <SelectValue placeholder="Select Inquiry Type" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="general">General Inquiry</SelectItem>
                    <SelectItem value="report">Vehicle History Report</SelectItem>
                    <SelectItem value="sticker">Window Sticker</SelectItem>
                    <SelectItem value="support">Technical Support</SelectItem>
                  </SelectContent>
                </Select>
                <Textarea placeholder="Your Message" rows={5} required />
                <Button type="submit" className="w-full">
                  <Send className="mr-2 h-4 w-4" />
                  Send Message
                </Button>
              </form>
              {formSubmitted && (
                <p className="mt-4 text-green-600 text-center font-medium">
                  Form submitted successfully!
                </p>
              )}
            </CardContent>
          </Card>

          <div className="space-y-8">
            <Card>
              <CardHeader>
                <CardTitle>Contact Information</CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="flex items-center space-x-3">
                  <Phone className="w-5 h-5 text-blue-600" />
                  <span>1-800-VEHICLE (1-800-834-4253)</span>
                </div>
                <div className="flex items-center space-x-3">
                  <Mail className="w-5 h-5 text-blue-600" />
                  <span>support@vehicleinsights.com</span>
                </div>
                <div className="flex items-center space-x-3">
                  <MapPin className="w-5 h-5 text-blue-600" />
                  <span>123 Auto Lane, Car City, VH 12345</span>
                </div>
                <div className="flex items-center space-x-3">
                  <Clock className="w-5 h-5 text-blue-600" />
                  <span>Mon-Fri: 9am-6pm EST</span>
                </div>
              </CardContent>
            </Card>

            <Card>
              <CardHeader>
                <CardTitle>Frequently Asked Questions</CardTitle>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2">
                  <li>
                    <Button variant="link" className="p-0 h-auto text-left">
                      How do I get a vehicle history report?
                    </Button>
                  </li>
                  <li>
                    <Button variant="link" className="p-0 h-auto text-left">
                      What information is included in a window sticker?
                    </Button>
                  </li>
                  <li>
                    <Button variant="link" className="p-0 h-auto text-left">
                      How accurate is the information in your reports?
                    </Button>
                  </li>
                  <li>
                    <Button variant="link" className="p-0 h-auto text-left">
                      Can I get a refund if I&apos;m not satisfied?
                    </Button>
                  </li>
                </ul>
              </CardContent>
            </Card>
          </div>
        </div>

        <div className="mt-16 text-center">
          <h2 className="text-2xl font-bold mb-4">Need Immediate Assistance?</h2>
          <p className="text-lg text-gray-600 mb-6">
            Our customer support team is available 24/7 to help you with any urgent inquiries.
          </p>
          <Button size="lg" variant="outline">
            Start Live Chat
          </Button>
        </div>
      </div>
    </div>
  )
}