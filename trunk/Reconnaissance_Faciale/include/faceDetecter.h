#ifndef FACEDETECTER_H
#define FACEDETECTER_H


#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"


#define NO_FACE_FOUND 0
#define SINGLE_FACE_FOUND 1
#define MANY_FACES_FOUND 2



////////////////////////////////////////////

class FaceDetecter 
{
 private:
  /// classifier that recognizes face
  cv::CascadeClassifier face_cascade;
  /// classifier that recognizes eyes
  cv::CascadeClassifier eyes_cascade;

 public:
  /** 
   * constructor
   * initialisation of classifiers with specified filenames
   * 
   * 
   * @return 
   */
  inline FaceDetecter () 
  {
    /* paths to description of what we're looking for */
    std::string face_cascade_name = "OpenCV-2.4.2/data/haarcascades/haarcascade_frontalface_alt.xml";
    std::string eyes_cascade_name = "OpenCV-2.4.2/data/haarcascades/haarcascade_eye_tree_eyeglasses.xml";
    //-- 1. Load the cascades
    if( !face_cascade.load( face_cascade_name ) ){ printf("FaceDetecter:--(!)Error loading %s\n",face_cascade_name.c_str()); exit(-1); };
    if( !eyes_cascade.load( eyes_cascade_name ) ){ printf("FaceDetecter:--(!)Error loading %s\n",eyes_cascade_name.c_str()); exit(-1); };
    cv::RNG rng(12345);
  }

  /** 
   * this funtion detects a face on a image and reframe the image
   * such that the face is the center. If many faces are found on the image, it 
   * reframes around the heighest one.
   * 
   *
   * @param img the image on which the face is detected
   * @param out the reframed image 
   * 
   * @return a code that can be equal to NO_FACE_FOUND SINGLE_FACE_FOUND or MANY_FACES_FOUND
   */
  /// detects face on image
  int detectAndReframe(cv::Mat img,cv::Mat& out);

  /** 
   * This function is called to take a picture from the user's webcam.
   * 
   * 
   * @return the image taken
   */
  cv::Mat takePictureFromWebcam();
};


#endif
