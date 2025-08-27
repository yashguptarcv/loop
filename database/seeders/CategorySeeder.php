<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                "parent" => "Technology",
                "children" => [
                    [
                        "name" => "Technology Expert of the Year",
                        "description" => "Recognizes an individual who has demonstrated outstanding innovation, leadership, and impact in advancing technology within the industry."
                    ],
                    [
                        "name" => "Business Elite of the Year",
                        "description" => "Honors an individual who has shown exceptional leadership, strategic vision, and success in driving business growth and performance."
                    ],
                    [
                        "name" => "Leadership in Artificial Intelligence",
                        "description" => "Recognizes an individual who has made significant contributions to advancing AI technologies and their transformative impact across industries."
                    ],
                    [
                        "name" => "Business Women of the Year",
                        "description" => "Honors an exceptional female leader who has demonstrated outstanding achievements, innovation, and leadership in driving business success."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Recognizes an individual who has made a significant impact through their influence, shaping opinions, trends, and driving positive change in their field or community."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Honors an individual who has demonstrated exceptional innovation, vision, and business acumen in successfully launching and growing a business."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Recognizes an individual who has demonstrated outstanding dedication, guidance, and support in helping others achieve personal or professional growth."
                    ],
                    [
                        "name" => "Digital Transformation Leader of the Year",
                        "description" => "Honors an individual who has successfully led and implemented innovative digital strategies, driving significant transformation and growth."
                    ],
                    [
                        "name" => "Blockchain Expert of the Year",
                        "description" => "Recognizes an individual who has demonstrated exceptional leadership and innovation in advancing blockchain technology and its applications."
                    ],
                    [
                        "name" => "Cybersecurity Expert of the Year",
                        "description" => "Honors an individual who has shown outstanding leadership in enhancing security measures, protecting data, and mitigating cyber threats."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Recognizes an individual for their extraordinary contributions, lasting impact, and exceptional dedication to their field over the course of their career."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Recognizes a company or organization that has demonstrated exceptional growth, innovation, and brand influence, setting a standard of excellence in its industry."
                    ],
                    [
                        "name" => "Cloud Innovator of the Year",
                        "description" => "Honors an individual or organization that has demonstrated outstanding leadership and innovation in leveraging cloud technologies to drive business transformation and growth."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Recognizes an exceptional Vice President who has demonstrated outstanding leadership, strategic vision, and impact in driving success within their organization."
                    ],
                    [
                        "name" => "Sustainability Expert of the Year",
                        "description" => "Honors an individual or organization that has demonstrated exceptional commitment and impact in promoting sustainable practices and environmental stewardship."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Recognizes an exceptional director who has demonstrated outstanding leadership, strategic decision-making, and contributions to the success of the organization or industry."
                    ],
                    [
                        "name" => "Company of the Year",
                        "description" => "Recognizes an organization that has achieved exceptional success, innovation, and impact, setting a benchmark of excellence in its industry."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Honors an individual who has demonstrated exceptional foresight, planning, and execution in driving successful strategies that have significantly impacted their organization or industry."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Recognizes an individual who has demonstrated exceptional foresight, innovation, and leadership in shaping the future of their industry or field."
                    ],
                    [
                        "name" => "Start up of the Year",
                        "description" => "Honors a new and innovative company that has demonstrated exceptional growth, creativity, and potential for long-term success in its industry."
                    ],
                    [
                        "name" => "Young Business Elite of the Year",
                        "description" => "Recognizes a young business leader who has shown exceptional vision, leadership, and achievement in driving business success and innovation."
                    ],
                    [
                        "name" => "Young Entrepreneur of the Year",
                        "description" => "Recognizes a young individual who has demonstrated exceptional innovation, leadership, and success in launching and growing a business."
                    ]
                ]
            ],
            [
                "parent" => "Health & Wellness",
                "children" => [
                    [
                        "name" => "Aesthetic Consultant of the Year",
                        "description" => "Honoring the expert whose exceptional insight and creativity have elevated the art of aesthetics, transforming spaces and experiences."
                    ],
                    [
                        "name" => "Aesthetician of the Year",
                        "description" => "Celebrating the skilled professional whose expertise and dedication to beauty and skin care have set new standards of excellence."
                    ],
                    [
                        "name" => "Ayurvedic Physician of the Year",
                        "description" => "Honoring the distinguished Ayurvedic physician whose knowledge, healing practices, and commitment to wellness have made a profound impact on health and well-being."
                    ],
                    [
                        "name" => "Animal Advocate of the Year",
                        "description" => "Celebrating the passionate advocate whose tireless efforts and dedication have made a lasting impact on the welfare and protection of animals."
                    ],
                    [
                        "name" => "Bio-Technology Leader of the Year",
                        "description" => "Honoring the visionary leader whose groundbreaking contributions and innovation in biotechnology have transformed the industry and advanced global health."
                    ],
                    [
                        "name" => "Cardiothoracic Surgeon of the Year",
                        "description" => "Celebrating the cardiothoracic surgeon whose skill, innovation, and unwavering commitment to saving lives have set new standards in heart and lung surgery."
                    ],
                    [
                        "name" => "Cardiologist of the Year",
                        "description" => "Honoring the cardiologist whose expertise, dedication, and groundbreaking contributions have significantly advanced heart health and patient care."
                    ],
                    [
                        "name" => "Gynecologist of the Year",
                        "description" => "Providing exceptional care and guidance in women's health with expertise, empathy, and compassion."
                    ],
                    [
                        "name" => "Clinical Mentor of the Year",
                        "description" => "For guiding the next generation of healthcare leaders with wisdom and dedication."
                    ],
                    [
                        "name" => "Cosmetic Plastic Surgeon of the Year",
                        "description" => "Transforming beauty and confidence, one skilled procedure at a time."
                    ],
                    [
                        "name" => "Cosmetologist of the Year",
                        "description" => "Enhancing beauty through innovation, artistry, and expert care."
                    ],
                    [
                        "name" => "Dentist of the Year",
                        "description" => "For brightening smiles and providing exceptional care, one tooth at a time."
                    ],
                    [
                        "name" => "Dermatologist of the Year",
                        "description" => "For healing skin with expertise and creating confidence from the surface to the soul."
                    ],
                    [
                        "name" => "Diabetologist of the Year",
                        "description" => "Championing diabetes care with precision, compassion, and transformative solutions."
                    ],
                    [
                        "name" => "Fitness Expert of the Year",
                        "description" => "For inspiring others to achieve their peak potential with expertise and unwavering dedication."
                    ],
                    [
                        "name" => "Fitness Mentor of the Year",
                        "description" => "Guiding individuals on a transformative journey toward better health and fitness, with passion and commitment."
                    ],
                    [
                        "name" => "Global Impact Leader of the Year",
                        "description" => "For making a profound difference worldwide through visionary leadership and lasting contributions."
                    ],
                    [
                        "name" => "Health and Wellness Visionary of the Year",
                        "description" => "Shaping the future of holistic health with innovative ideas and a commitment to wellness."
                    ],
                    [
                        "name" => "Health Coach of the Year",
                        "description" => "Empowering individuals to live their healthiest, happiest lives through personalized guidance and support."
                    ],
                    [
                        "name" => "Healthcare Compliance Expert of the Year",
                        "description" => "Ensuring integrity and excellence in healthcare practices with unwavering commitment to standards and regulations."
                    ],
                    [
                        "name" => "Healthcare Education Leader of the Year",
                        "description" => "Transforming the future of healthcare through education, mentorship, and a passion for excellence."
                    ],
                    [
                        "name" => "Healthcare Marketing Expert of the Year",
                        "description" => "Strategizing impactful campaigns that connect patients with the best healthcare services."
                    ],
                    [
                        "name" => "Healthcare Researcher of the Year",
                        "description" => "Pioneering breakthroughs in healthcare through innovative research and an unrelenting pursuit of knowledge."
                    ],
                    [
                        "name" => "Healthcare Technology Leader of the Year",
                        "description" => "Driving advancements in healthcare through cutting-edge technology and visionary leadership."
                    ],
                    [
                        "name" => "Mental Healthcare Expert of the Year",
                        "description" => "Championing mental well-being with expert care, empathy, and an unwavering commitment to healing."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Honoring a lifetime of dedication, innovation, and transformative contributions to the healthcare industry."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Leading with vision, innovation, and unmatched expertise to drive success and inspire teams."
                    ],
                    [
                        "name" => "MedTech Expert of the Year",
                        "description" => "Revolutionizing the medical field with advanced technology and a relentless drive to improve patient care."
                    ],
                    [
                        "name" => "Neurologist of the Year",
                        "description" => "For unraveling the complexities of the brain and nervous system with unmatched expertise and compassion."
                    ],
                    [
                        "name" => "Nutritionist of the Year",
                        "description" => "Nourishing lives with tailored advice and promoting optimal health through the power of food."
                    ],
                    [
                        "name" => "Oncologist of the Year",
                        "description" => "For delivering hope, healing, and life-changing treatments to cancer patients with expertise and compassion."
                    ],
                    [
                        "name" => "Dietician of the Year",
                        "description" => "For nourishing lives with tailored nutrition and promoting healthier futures."
                    ],
                    [
                        "name" => "Physician of the Year",
                        "description" => "For exemplary care, healing hearts, and making a lasting impact on patient health."
                    ],
                    [
                        "name" => "Healthcare Expert of the Year",
                        "description" => "For advancing healthcare with exceptional knowledge, innovation, and passion."
                    ],
                    [
                        "name" => "Home Care Expert of the Year",
                        "description" => "Delivering compassionate, professional care to those in need, right at home."
                    ],
                    [
                        "name" => "Healthcare Entrepreneur of the Year",
                        "description" => "For pioneering new healthcare solutions and reshaping the industry with vision and innovation."
                    ],
                    [
                        "name" => "Healthcare Woman of the Year",
                        "description" => "Empowering health and inspiring change with unwavering dedication and passion."
                    ],
                    [
                        "name" => "Eye Care Expert of the Year",
                        "description" => "Bringing vision to life with precision, care, and a dedication to seeing the world clearly."
                    ],
                    [
                        "name" => "Facial Surgeon of the Year",
                        "description" => "For sculpting beauty and restoring confidence through expert, life-changing procedures."
                    ],
                    [
                        "name" => "Urologist of the Year",
                        "description" => "Recognizing the urologist whose exceptional skill, dedication, and innovations have significantly impacted patient care."
                    ],
                    [
                        "name" => "Wellness Mentor of the Year",
                        "description" => "Honoring the individual whose guidance and leadership have inspired others to achieve personal wellness and holistic health."
                    ],
                    [
                        "name" => "Wellness Expert of the Year",
                        "description" => "Celebrating the expert whose knowledge, strategies, and dedication to wellness have transformed lives and communities."
                    ],
                    [
                        "name" => "Healthcare Visionary of the Year",
                        "description" => "Recognizing the visionary whose groundbreaking ideas and contributions have reshaped the future of healthcare."
                    ],
                    [
                        "name" => "Wellness Visionary of the Year",
                        "description" => "Celebrating the leader whose forward-thinking approach and innovations have set new standards in wellness and holistic health."
                    ]
                ]
            ],
            [
                "parent" => "Finance",
                "children" => [
                    [
                        "name" => "Finance Expert of the Year",
                        "description" => "Honors an individual who has demonstrated exceptional knowledge, expertise, and impact in the financial industry, driving innovation and success in financial management and strategy."
                    ],
                    [
                        "name" => "Business Elite of the Year",
                        "description" => "Recognizes an individual who has demonstrated outstanding leadership, innovation, and success in the financial sector, driving significant impact and growth."
                    ],
                    [
                        "name" => "Business Woman of the Year",
                        "description" => "Recognizes an exceptional female leader who has demonstrated outstanding achievements, leadership, and innovation within the financial sector."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Honors an individual who has made a significant impact through their influence, shaping trends, discussions, and decisions within the financial industry."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Recognizes an individual who has demonstrated exceptional innovation, vision, and success in launching and growing a business within the financial sector."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Honors an individual who has provided exceptional guidance, support, and mentorship, helping others achieve success and growth in the financial industry."
                    ],
                    [
                        "name" => "Start-Up of the Year",
                        "description" => "Recognizes a new financial company that has demonstrated exceptional innovation, growth, and potential for long-term success in transforming the financial industry."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Honors an individual who has demonstrated exceptional foresight, innovation, and leadership in shaping the future of the financial industry through transformative ideas and strategies."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Recognizes an individual who has demonstrated exceptional skill in developing and executing strategies that have driven significant growth, innovation, and success in the financial sector."
                    ],
                    [
                        "name" => "Company of the Year",
                        "description" => "Recognizes a financial organization that has demonstrated outstanding performance, innovation, and leadership, setting a benchmark for success and growth in the industry."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Honors an exceptional director who has demonstrated outstanding leadership, strategic decision-making, and significant contributions to the success and growth of a financial organization."
                    ],
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Recognizes an individual or organization that has demonstrated exceptional leadership in integrating sustainable practices and environmental responsibility within the financial sector."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Honors an exceptional Vice President who has demonstrated outstanding leadership, strategic vision, and impactful contributions to the growth and success of a financial organization."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Recognizes a financial institution or company that has demonstrated exceptional growth, innovation, and influence, setting a standard of excellence and trust within the financial industry."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Honors an individual who has made extraordinary, lasting contributions to the financial industry, demonstrating exceptional leadership, innovation, and influence over the course of their career."
                    ],
                    [
                        "name" => "Venture Capitalist of the Year",
                        "description" => "Recognizes an outstanding individual who has demonstrated exceptional skill, foresight, and impact in identifying, investing in, and nurturing high-potential startups within the financial sector."
                    ],
                    [
                        "name" => "Wealth Management Leader of the Year",
                        "description" => "Honors an individual or organization that has demonstrated exceptional leadership, innovation, and success in providing wealth management services and strategies, helping clients achieve financial growth and security."
                    ]
                ]
            ],
            [
                "parent" => "Sustainability",
                "children" => [
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Recognizes CEOs or leaders championing environmental responsibility."
                    ],
                    [
                        "name" => "Corporate Sustainability Initiative of the Year",
                        "description" => "Highlights impactful sustainability programs."
                    ],
                    [
                        "name" => "Green Business of the Year",
                        "description" => "Celebrates eco-friendly business operations."
                    ],
                    [
                        "name" => "Leadership in Renewable Energy Solutions",
                        "description" => "Honors innovation in renewable energy."
                    ],
                    [
                        "name" => "Leadership in Carbon Footprint Reduction",
                        "description" => "Recognizes efforts to lower emissions."
                    ],
                    [
                        "name" => "Innovation in Waste Management",
                        "description" => "Highlights advancements in recycling and waste reduction."
                    ],
                    [
                        "name" => "Leader in Biodiversity Preservation",
                        "description" => "Celebrates contributions to protecting ecosystems."
                    ],
                    [
                        "name" => "Best Circular Economy Initiative",
                        "description" => "Recognizes effective reuse and recycling programs."
                    ]
                ]
            ],
            [
                "parent" => "Retail and E-commerce",
                "children" => [
                    [
                        "name" => "Retail Expert of the Year",
                        "description" => "Recognizes CMOs or CEOs driving retail and e-commerce excellence."
                    ],
                    [
                        "name" => "Leadership Award in Omnichannel Experience",
                        "description" => "Celebrates seamless integration of online and offline shopping."
                    ],
                    [
                        "name" => "E-commerce Innovation",
                        "description" => "Highlights innovation in online retail platforms."
                    ],
                    [
                        "name" => "Customer Engagement Strategy of the Year",
                        "description" => "Honors exceptional strategies to connect with customers."
                    ],
                    [
                        "name" => "Retail Tech Innovator of the Year",
                        "description" => "Recognizes cutting-edge retail technology."
                    ],
                    [
                        "name" => "Loyalty Program of the Year",
                        "description" => "Celebrates innovative customer retention strategies."
                    ],
                    [
                        "name" => "Leadership in E-commerce Growth",
                        "description" => "Highlights significant achievements in digital sales."
                    ],
                    [
                        "name" => "Leadership Award in Retail Design",
                        "description" => "Recognizes creative and effective store layouts."
                    ]
                ]
            ],
            [
                "parent" => "Manufacturing",
                "children" => [
                    [
                        "name" => "Manufacturing Leader of the Year",
                        "description" => "Recognizes COOs or CEOs transforming manufacturing operations."
                    ],
                    [
                        "name" => "Excellence in Manufacturing Processes",
                        "description" => "Highlights operational and production excellence."
                    ],
                    [
                        "name" => "Best Innovation in Product Design",
                        "description" => "Recognizes cutting-edge product designs."
                    ],
                    [
                        "name" => "Sustainable Manufacturing Award",
                        "description" => "Honors eco-conscious manufacturing practices."
                    ],
                    [
                        "name" => "Best Use of Robotics in Manufacturing",
                        "description" => "Celebrates automation advancements."
                    ],
                    [
                        "name" => "Innovation in Supply Chain Integration",
                        "description" => "Recognizes streamlined manufacturing processes."
                    ],
                    [
                        "name" => "Leadership in Industrial Safety Standards",
                        "description" => "Highlights focus on workplace safety."
                    ],
                    [
                        "name" => "Top Performer in Global Production",
                        "description" => "Celebrates high-performing global manufacturers."
                    ]
                ]
            ],
            [
                "parent" => "Education",
                "children" => [
                    [
                        "name" => "Education Expert of the Year",
                        "description" => "Honors outstanding contributions and leadership in shaping future generations."
                    ],
                    [
                        "name" => "Business Woman of the Year",
                        "description" => "Recognizes transformative leadership and excellence in shaping educational success."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Celebrates inspiring change and shaping the future of learning."
                    ],
                    [
                        "name" => "Professor of the Year",
                        "description" => "Recognizes outstanding dedication, innovation, and impact on student success."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Honors groundbreaking innovations and transformative contributions to the education industry."
                    ],
                    [
                        "name" => "Leadership Development Program of the Year",
                        "description" => "Recognizes exceptional growth and empowerment of future leaders."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Celebrates inspiring growth, guidance, and unwavering support in shaping future leaders."
                    ],
                    [
                        "name" => "Start-up of the Year",
                        "description" => "Recognizes innovative solutions and transformative impact on learning."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Honors groundbreaking ideas and transformative leadership shaping the future."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Recognizes innovative planning and impactful solutions driving educational success."
                    ],
                    [
                        "name" => "Company of the Year",
                        "description" => "Honors exceptional achievements, innovation, and impact in the industry."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Celebrates exceptional leadership, vision, and transformative impact within their organization."
                    ],
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Honors pioneering eco-friendly initiatives and promoting sustainable practices in learning."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Recognizes outstanding leadership, innovation, and dedication to educational excellence."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Celebrates exceptional impact, innovation, and leadership in the education industry."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Honors a lifetime of dedication, excellence, and transformative impact."
                    ]
                ]
            ],
            [
                "parent" => "Media and Entertainment",
                "children" => [
                    [
                        "name" => "Media Expert of the Year",
                        "description" => "Honors exceptional insight, innovation, and influence in the media industry."
                    ],
                    [
                        "name" => "Business Elite of the Year",
                        "description" => "Recognizes exceptional leadership and groundbreaking contributions to the industry."
                    ],
                    [
                        "name" => "Business Woman of the Year",
                        "description" => "Celebrates outstanding leadership, influence, and contributions to the media industry."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Recognizes outstanding impact, creativity, and ability to inspire and engage audiences."
                    ],
                    [
                        "name" => "Journalist of the Year",
                        "description" => "Honors exceptional storytelling, integrity, and impactful contributions to the media industry."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Celebrates innovative leadership and transformative contributions to the media landscape."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Honors guidance and inspiration for the next generation of media professionals."
                    ],
                    [
                        "name" => "Start-up of the Year",
                        "description" => "Recognizes innovative disruption and significant impact on the media industry."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Honors groundbreaking ideas and transformative leadership shaping the future of the industry."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Recognizes exceptional planning, innovation, and transformative impact on the media industry."
                    ],
                    [
                        "name" => "Company of the Year",
                        "description" => "Celebrates exceptional innovation, leadership, and influence in the media industry."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Honors outstanding leadership, vision, and exceptional contributions to the field."
                    ],
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Recognizes impactful eco-friendly initiatives and championing sustainability efforts."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Honors exceptional leadership, innovation, and influence in shaping the media industry."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Recognizes exceptional innovation, influence, and transformative impact on the media industry."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Honors a lifetime of exceptional contributions, leadership, and lasting impact in media and entertainment."
                    ],
                    [
                        "name" => "Content Creation Expert of the Year",
                        "description" => "Recognizes outstanding creativity, innovation, and influence in digital storytelling."
                    ]
                ]
            ],
            [
                "parent" => "Marketing",
                "children" => [
                    [
                        "name" => "CEO of the Year",
                        "description" => "Recognizes visionary CEOs who have demonstrated exceptional leadership and strategic direction, driving their brands to new heights."
                    ],
                    [
                        "name" => "CMO of the Year",
                        "description" => "Honors Chief Marketing Officers who have spearheaded innovative marketing strategies, shaping brand identities and driving market success."
                    ],
                    [
                        "name" => "Business Elite of the Year",
                        "description" => "Celebrates exceptional leadership, innovation, and impactful strategies in the marketing industry."
                    ],
                    [
                        "name" => "Business Woman of the Year",
                        "description" => "Honors leadership, innovation, and transformative impact in the marketing industry."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Recognizes exceptional creativity, engagement, and impact on brand success."
                    ],
                    [
                        "name" => "Marketing Expert of the Year",
                        "description" => "Honors outstanding strategy, innovation, and influence in driving brand success."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Celebrates exceptional innovation, leadership, and transformative impact in the industry."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Honors guidance, inspiration, and shaping the next generation of marketing leaders."
                    ],
                    [
                        "name" => "Start-up of the Year",
                        "description" => "Recognizes innovative strategies and disruptive impact on the marketing industry."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Celebrates exceptional innovation, influence, and lasting impact in its industry."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Honors exceptional leadership, strategy, and transformative impact on brand growth."
                    ],
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Recognizes innovative eco-friendly practices and championing environmental responsibility."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Honors exceptional leadership, vision, and transformative contributions to the marketing industry."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Recognizes exceptional foresight, innovation, and impactful decision-making in driving success."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Honors groundbreaking ideas and transformative leadership shaping the future of the industry."
                    ],
                    [
                        "name" => "Content Creator of the Year",
                        "description" => "Recognizes exceptional creativity, innovation, and impact in digital storytelling."
                    ],
                    [
                        "name" => "Digital Marketing Leader of the Year",
                        "description" => "Honors innovative strategies and outstanding success in driving brand growth online."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Celebrates a lifetime of exceptional contributions, leadership, and lasting impact in shaping the marketing industry."
                    ]
                ]
            ],
            [
                "parent" => "Fashion & Beauty",
                "children" => [
                    [
                        "name" => "Business Elite of the Year",
                        "description" => "Honoring the Business Elite of the Year in Fashion and Beauty for exceptional leadership, innovation, and transformative impact on the industry."
                    ],
                    [
                        "name" => "Business Women of the Year",
                        "description" => "Celebrating the Business Woman of the Year for her exceptional leadership, innovation, and transformative contributions to the fashion industry."
                    ],
                    [
                        "name" => "Fashion Expert of the Year",
                        "description" => "Recognizing the Fashion Expert of the Year for outstanding creativity, trendsetting influence, and exceptional contributions to the fashion industry."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Honoring the Influencer of the Year in Fashion for their impactful style, creativity, and ability to inspire global trends."
                    ],
                    [
                        "name" => "Fashion Designer of the Year",
                        "description" => "Celebrating the Fashion Designer of the Year for exceptional creativity, innovation, and influence in shaping the future of fashion."
                    ],
                    [
                        "name" => "Brand Strategist of the Year",
                        "description" => "Honoring the Brand Strategist of the Year in Fashion and Beauty for exceptional vision, innovation, and impact on brand growth."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Recognizing the Entrepreneur of the Year in Fashion and Beauty for pioneering innovation, leadership, and transformative contributions to the industry."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Honoring the Mentor of the Year in Fashion for inspiring, guiding, and shaping the future of emerging designers and talent."
                    ],
                    [
                        "name" => "Start-up of the Year",
                        "description" => "Celebrating the innovative vision and bold strides of a rising star reshaping the fashion industry with creativity and impact."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Honoring the trailblazer whose groundbreaking ideas and leadership are shaping the future of fashion."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Recognizing the mastermind whose exceptional strategy and insight have driven success and innovation in fashion and beauty."
                    ],
                    [
                        "name" => "Company of the Year",
                        "description" => "Celebrating the brand that has set new standards of excellence, innovation, and impact in the fashion and beauty industry."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Honoring the visionary director whose leadership and creativity have elevated the fashion and beauty industry to new heights."
                    ],
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Recognizing the pioneer driving positive change with innovative, eco-conscious solutions that are shaping a sustainable future in fashion and beauty."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Honoring the dynamic VP whose leadership, vision, and strategic impact have transformed the fashion and beauty industry."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Celebrating the brand that has defined excellence, innovation, and influence, setting the standard in fashion and beauty."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Honoring a remarkable career of excellence, innovation, and enduring impact that has shaped the fashion and beauty industry for generations."
                    ]
                ]
            ],
            [
                "parent" => "Human Resource",
                "children" => [
                    [
                        "name" => "Business Elite of the Year",
                        "description" => "Recognizing the exceptional leader whose visionary business acumen and remarkable achievements have set a new standard of success in their industry."
                    ],
                    [
                        "name" => "Business Women of the Year",
                        "description" => "Celebrating the extraordinary woman whose leadership, innovation, and impact have redefined success and inspired change in the business world."
                    ],
                    [
                        "name" => "CEO of the Year",
                        "description" => "Honoring the visionary CEO whose exceptional leadership, innovation, and strategic decisions have driven remarkable growth and success."
                    ],
                    [
                        "name" => "HR Expert of the Year",
                        "description" => "Recognizing the HR leader whose strategic vision and dedication to people development have transformed organizational culture and success."
                    ],
                    [
                        "name" => "Influencer of the Year",
                        "description" => "Celebrating the influencer whose creativity, authenticity, and impact have shaped trends and inspired audiences worldwide."
                    ],
                    [
                        "name" => "Talent Acquisition Leader",
                        "description" => "Honoring the leader whose innovative strategies and dedication to attracting top talent have elevated organizational success and growth."
                    ],
                    [
                        "name" => "Entrepreneur of the Year",
                        "description" => "Celebrating the visionary entrepreneur whose innovation, resilience, and business acumen have driven exceptional growth and success."
                    ],
                    [
                        "name" => "Mentor of the Year",
                        "description" => "Honoring the mentor whose guidance, wisdom, and unwavering support have inspired and empowered others to reach their full potential."
                    ],
                    [
                        "name" => "Start-up of the Year",
                        "description" => "Celebrating the groundbreaking startup whose innovation, vision, and growth have redefined the industry and set new standards of success."
                    ],
                    [
                        "name" => "Visionary of the Year",
                        "description" => "Honoring the trailblazer whose forward-thinking ideas and bold leadership are shaping the future and driving positive change."
                    ],
                    [
                        "name" => "Strategist of the Year",
                        "description" => "Recognizing the strategic mastermind whose exceptional foresight and innovative approach have driven remarkable success and growth."
                    ],
                    [
                        "name" => "Company of the Year",
                        "description" => "Celebrating the company whose excellence, innovation, and impact have set the standard for success and leadership in its industry."
                    ],
                    [
                        "name" => "Director of the Year",
                        "description" => "Honoring the director whose visionary leadership, creativity, and exceptional execution have set new benchmarks of success and excellence."
                    ],
                    [
                        "name" => "Sustainability Leader of the Year",
                        "description" => "Recognizing the leader whose unwavering commitment to sustainability and innovative solutions is driving lasting change and a greener future."
                    ],
                    [
                        "name" => "VP of the Year",
                        "description" => "Celebrating the VP whose exceptional leadership, vision, and strategic impact have driven remarkable success and growth within the organization."
                    ],
                    [
                        "name" => "Brand of the Year",
                        "description" => "Honoring the brand that has demonstrated exceptional innovation, influence, and excellence, setting new standards in its industry."
                    ],
                    [
                        "name" => "Lifetime Achievement Award",
                        "description" => "Celebrating a distinguished career of unparalleled contributions, leadership, and lasting impact that has shaped and inspired an entire industry."
                    ],
                    [
                        "name" => "Recruiter of the Year",
                        "description" => "Honoring the recruiter whose exceptional talent identification, dedication, and innovative approach have shaped the success of organizations and empowered careers."
                    ]
                ]
            ]
        ];

        // Helper function to generate slug with parent category prefix for uniqueness
        $generateSlug = function($name, $parentName = null) {
            if ($parentName) {
                return Str::slug($parentName . '-' . $name);
            }
            return Str::slug($name);
        };

        // Helper function to generate meta title from name
        $generateMetaTitle = function($name) {
            return $name . " - Award Category";
        };

        // Helper function to generate meta description from description
        $generateMetaDescription = function($description, $name) {
            return substr($description, 0, 150) . "... Learn more about the " . $name . " award category.";
        };

        DB::transaction(function() use ($categories, $generateSlug, $generateMetaTitle, $generateMetaDescription) {
            $position = 1;
            
            foreach ($categories as $categoryData) {
                // Insert parent category
                $parentId = DB::table('categories')->insertGetId([
                    'parent_id' => null,
                    'name' => $categoryData['parent'],
                    'slug' => $generateSlug($categoryData['parent']),
                    'description' => "Awards and recognition in the " . $categoryData['parent'] . " industry, celebrating excellence and innovation.",
                    'image' => null,
                    'status' => 'A',
                    'position' => $position++,
                    'meta_title' => $categoryData['parent'] . " Awards - Excellence Recognition",
                    'meta_description' => "Discover award categories in " . $categoryData['parent'] . " recognizing outstanding achievements, leadership, and innovation in the industry.",
                    'meta_keywords' => strtolower($categoryData['parent']) . " awards, excellence, recognition, leadership, innovation",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert child categories
                $childPosition = 1;
                foreach ($categoryData['children'] as $child) {
                    DB::table('categories')->insert([
                        'parent_id' => $parentId,
                        'name' => $child['name'],
                        'slug' => $generateSlug($child['name'], $categoryData['parent']),
                        'description' => $child['description'],
                        'image' => null,
                        'status' => 'A',
                        'position' => $childPosition++,
                        'meta_title' => $generateMetaTitle($child['name']),
                        'meta_description' => $generateMetaDescription($child['description'], $child['name']),
                        'meta_keywords' => strtolower(str_replace(' ', ', ', $child['name'])) . ", award, recognition, " . strtolower($categoryData['parent']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        $this->command->info('Categories seeded successfully!');
        $this->command->info('Total parent categories: ' . count($categories));
        $this->command->info('Total child categories: ' . array_sum(array_map(function($cat) { return count($cat['children']); }, $categories)));
    }
}