# Frame Price Estimator

Welcome to the **Frame Price Estimator** project! This web-based tool allows users to quickly and accurately calculate the cost of framing their photos based on dimensions and personalised preferences. Whether you're framing a single image or multiple pieces, this tool makes it simple to get an instant price estimate.

## Features
- **Customizable Photo Dimensions**: Input your photo's width and height in a variety of units (mm, cm, or inches) to get an accurate estimate.
- **Postage Options**: Choose from three postage options—Economy, Rapid, or Next Day—to factor shipping costs into the total price.
- **VAT Inclusion**: Optionally include Value Added Tax (VAT) in your estimate for more accurate pricing.
- **Email Quotation**: Receive a detailed framing cost estimate directly to your inbox.
- **Opt-In for Updates**: Stay informed about new services or promotions by opting in to receive future updates.

## How to Use the Frame Price Estimator
Follow these simple steps to get your framing price estimate:

1. **Enter Photo Dimensions**:  
   Input the width and height of your photo in the appropriate fields. Select the unit of measurement (mm, cm, or inches) from the dropdown.

2. **Select Postage Option**:  
   Choose your preferred postage option—Economy, Rapid, or Next Day—from the available choices.

3. **Include VAT**:  
   If you want the estimate to include VAT (Value Added Tax), check the "Include VAT" box.

4. **Provide Email for Quotation**:  
   Enter your email address where you'd like the cost estimate to be sent.

5. **Opt-In for Updates**:  
   If you'd like to receive future updates, promotions, or more information about framing services, check the box to opt-in for email notifications.

6. **Submit**:  
   Click the "Submit" button to calculate your framing estimate and receive it by email.

## How It Works
This tool is designed for simplicity and ease of use. The process behind the scenes is as follows:

1. The HTML form collects essential data such as photo dimensions, postage preferences, VAT inclusion, and your email address.
2. The information is then sent to a **PHP script** (`framing.php`), which performs the necessary calculations to determine the framing cost based on your inputs.
3. The calculated estimate is emailed to the provided email address, ensuring you get the information you need in a timely manner.

## Form Details
The HTML form on the front end gathers all necessary data for the cost calculation. It includes:
- Fields for entering your photo dimensions.
- A dropdown menu to select your preferred unit of measurement.
- Radio buttons for selecting the postage method.
- A checkbox to include VAT in your pricing.
- A field to submit your email address for receiving the estimate.

The entire process is designed to be fast, straightforward, and fully functional with minimal user input.

## Technologies Used
- **HTML** for the user interface and form structure.
- **PHP** for processing form data and performing cost calculations.
- **CSS** for styling and responsive design.

## Conclusion
The **Frame Price Estimator** is a simple yet powerful tool designed to streamline the framing cost estimation process. With customizable options for photo size, postage, and VAT, you can quickly receive an accurate cost estimate, helping you make informed decisions for your framing needs.

Feel free to explore, customise, and integrate this tool into your workflow to make your photo framing experience more efficient!
