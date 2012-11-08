


import edu.cmu.sphinx.frontend.util.AudioFileDataSource;
import edu.cmu.sphinx.recognizer.Recognizer;
import edu.cmu.sphinx.result.Result;
import edu.cmu.sphinx.util.props.ConfigurationManager;

import javax.sound.sampled.UnsupportedAudioFileException;
import java.io.File;
import java.io.IOException;
import java.net.URL;

/** A simple example that shows how to transcribe a continuous audio file that has multiple utterances in it. */
public class Transcriber {


    public static void main(String[] args) throws IOException, UnsupportedAudioFileException {
        URL audioURL;

        if (args.length > 0) {
            audioURL = new File(args[0]).toURI().toURL();
        } else {
            audioURL = Transcriber.class.getResource("rsc/10001-90210-01803.wav");
        }

        URL configURL = Transcriber.class.getResource("rsc/config.xml");

        ConfigurationManager cm = new ConfigurationManager(configURL);
        Recognizer recognizer = (Recognizer) cm.lookup("recognizer");

        /* allocate the resource necessary for the recognizer */
        recognizer.allocate();

        // configure the audio input for the recognizer
        AudioFileDataSource dataSource = (AudioFileDataSource) cm.lookup("audioFileDataSource");
        dataSource.setAudioFile(audioURL, null);

        // Loop until last utterance in the audio file has been decoded, in which case the recognizer will return null.
        Result result;
        while ((result = recognizer.recognize())!= null) {

                String resultText = result.getBestResultNoFiller();
                System.out.println(resultText);
        }
    }
}
